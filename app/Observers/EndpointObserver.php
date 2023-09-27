<?php

namespace App\Observers;

use App\Models\Check;
use App\Models\Endpoint;
use Illuminate\Support\Arr;
use App\Events\EndpointWentDown;
use App\Events\EndpointRecovered;
use Illuminate\Support\Facades\Log;

class EndpointObserver
{
    public function creating(Endpoint $endpoint): void {
        $this->parseUrl($endpoint);
    }
    public function updating(Endpoint $endpoint): void {
        $this->parseUrl($endpoint);
    }

    protected function parseUrl(Endpoint $endpoint)
    {
        $parsed = parse_url("{$endpoint->site->url()}/$endpoint->location");
        $endpoint->location = '/' . trim(trim(Arr::get($parsed, 'path'), '/') . '?' . Arr::get($parsed, 'query'), '?');
        $endpoint->next_check = now()->addSeconds($endpoint->frequency);
    }
}
