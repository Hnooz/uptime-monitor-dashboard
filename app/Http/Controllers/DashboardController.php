<?php

namespace App\Http\Controllers;

use App\Http\Resources\SiteResource;
use App\Models\Site;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Dashboard', [
            'sites' => SiteResource::collection(Site::get()),
        ]);
    }
}
