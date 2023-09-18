<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Endpoint;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEndpointRequest;
use App\Http\Requests\DestroyEndpointRequest;
use App\Http\Resources\EndpointResource;

class EndpointController extends Controller
{
    public function index(Endpoint $endpoint)
    {
        $this->authorize('show', $endpoint);

        return inertia()->render('Endpoints/index', [
            'endpoint' => EndpointResource::make($endpoint)
        ]);
    }

    public function store(StoreEndpointRequest $request, Site $site)
    {
        $site->endpoints()->create($request->validated());

        return back();
    }

    public function update(Endpoint $endpoint)
    {
        $this->authorize('update', $endpoint);

        $endpoint->update(request()->only(['location', 'frequency']));

        return back();
    }

    public function destroy(DestroyEndpointRequest $request, Endpoint $endpoint)
    {
        $endpoint->delete();

        return back();
    }
}
