<?php

namespace App\Providers;

use App\Models\Check;
use App\Models\Endpoint;
use App\Events\EndpointWentDown;
use App\Listeners\SendDownEmail;
use App\Observers\CheckObserver;
use App\Events\EndpointRecovered;
use App\Observers\EndpointObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendDownEmailNotification;
use App\Listeners\SendRecoveredEmailNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        EndpointWentDown::class => [
            SendDownEmailNotification::class,
        ],
        
        EndpointRecovered::class => [
            SendRecoveredEmailNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Endpoint::observe(EndpointObserver::class);
        Check::observe(CheckObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
