<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Endpoint;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\SiteResource;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Resources\EndpointResource;

class UpdateSiteConnectionController extends Controller
{
    public function __invoke(Request $request, Site $site)
    {
        $site->update([ 'is_connected' => $request->is_connected ]);

        return back();
    }
}
