<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSiteRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class SiteNotificationController extends Controller
{
    public function store(Request $request, Site $site)
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

    public function destroy(Request $request, Site $site)
    {
        $site->update([
            'notification_emails' => array_diff($site->notification_emails, [$request->email])
        ]);

        return back();
    }

}
