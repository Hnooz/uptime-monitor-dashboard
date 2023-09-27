<?php

namespace App\Listeners;

use App\Notifications\EndpointDownNotification;
use App\Notifications\EndpointRecoveredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendRecoveredEmailNotification
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
                    ->notify(new EndpointRecoveredNotification($event->check->endpoint));
        });
    }
}
