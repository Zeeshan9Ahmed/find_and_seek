<?php

namespace App\Listeners;

use App\Events\SendNotificationForMessage;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationForMessageListener
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
     * @param  \App\Events\SendNotificationForMessage  $event
     * @return void
     */
    public function handle(SendNotificationForMessage $event)
    {
        $save_notification = app(CreateDBNotification::class)->execute($event->data);
        return $send_push = app(PushNotificationService::class)->execute($event->data,$event->token);
    }
}
