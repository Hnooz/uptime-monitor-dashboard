<?php

namespace App\Listeners;

use App\Notifications\EndpointDownNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendDownEmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        collect($event->check->endpoint->site->notification_emails)->each(function ($email) use ($event){
            Notification::route('mail', $email)
                    ->notify(new EndpointDownNotification($event->check->endpoint));
        });
    }
}
