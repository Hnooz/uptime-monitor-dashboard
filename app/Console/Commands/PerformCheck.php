<?php

namespace App\Console\Commands;

use App\Jobs\PerformEndpointCheck;
use App\Models\Endpoint;
use Illuminate\Console\Command;

class PerformCheck extends Command
{
    protected $signature = 'check:perform';

    protected $description = 'next check perform';

    public function handle()
    {
        Endpoint::where('next_check', '<=', now())->each(function($endpoint){
            PerformEndpointCheck::dispatch($endpoint);
        });

        return Command::SUCCESS;
    }
}
