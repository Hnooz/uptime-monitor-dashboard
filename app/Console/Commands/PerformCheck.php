<?php

namespace App\Console\Commands;

use App\Jobs\PerformEndpointCheck;
use App\Models\Endpoint;
use App\Models\Site;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PerformCheck extends Command
{
    protected $signature = 'check:perform';

    protected $description = 'next check perform';

    public function handle()
    {
        try {
           $sites = Site::where('is_connected', true)->with(['endpoints' => function($q){
                $q->where('next_check', '<=', now());
            }])->get();
        } catch (\Throwable $th) {
           Log::info($th);
        }

        collect($sites)->each(function($site){
            collect($site->endpoints)->each(function($endpoint){
                PerformEndpointCheck::dispatch($endpoint);
            });
        });
        

        return Command::SUCCESS;
    }
}
