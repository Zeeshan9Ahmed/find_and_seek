<?php

namespace App\Listeners;

use App\Events\ProfileViewEvent;
use App\Services\Notifications\CreateDBNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProfileViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProfileViewEvent  $event
     * @return void
     */
    public function handle(ProfileViewEvent $event)
    {
        
        return $save_notification = app(CreateDBNotification::class)->execute($event->data);
        // return $send_push = app(PushNotificationService::class)->execute($event->data,$event->token);
    }
}
