<?php

namespace App\Observers;

use App\Models\Site;
use Illuminate\Support\Arr;

class SiteObserver
{
    public function creating(Site $site)
    {
        $parsed = parse_url($site->domain);

        $site->scheme = Arr::get($parsed, 'scheme');
        $site->domain = Arr::get($parsed, 'host');
    }

 

}
