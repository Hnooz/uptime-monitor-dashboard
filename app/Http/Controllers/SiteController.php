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

class SiteController extends Controller
{
    public function show(Site $site)
    {
        
        return inertia()->render('Sites/show', [
            'site' => SiteResource::make($site->load('endpoints:id')),
            'endpoints' => EndpointResource::collection(Endpoint::where('site_id', $site->id)->get()),
        ]);
    }

    public function store(StoreSiteRequest $request)
    {
        $data = $request->validated();
        
        $site = Site::create($data);

        return redirect()->route('dashboard', $site);
    }

    public function update(Request $request, Site $site)
    {
        $this->authorize('storeNotificationEmail', $site);
        
        $request->validate([
            'email' => ['required', 'email', Rule::notIn($site->notification_emails)]
        ]);

        $site->update([
            'notification_emails' => Arr::prepend($site->notification_emails, $request->email)
        ]);

        return back();
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return back();
    }
}
