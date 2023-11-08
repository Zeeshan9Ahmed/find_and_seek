<?php

namespace App\Providers;

use App\Events\AcceptFriendRequestEvent;
use App\Events\ProfileViewEvent;
use App\Events\SendFriendRequestEvent;
use App\Events\SendNotificationForMessage;
use App\Events\SendNotificationToAdminEvent;
use App\Events\SendNotificationToRecruiterEvent;
use App\Listeners\ProfileViewListener;
use App\Listeners\SendNotificationForMessageListener;
use App\Listeners\SendNotificationToRecruiterListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendNotificationToRecruiterEvent::class => [
            SendNotificationToRecruiterListener::class
        ],
        SendNotificationForMessage::class => [
            SendNotificationForMessageListener::class
        ],
        ProfileViewEvent::class => [
            ProfileViewListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
