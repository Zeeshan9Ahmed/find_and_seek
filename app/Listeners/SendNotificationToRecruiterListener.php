<?php

namespace App\Listeners;

use App\Events\SendNotificationToRecruiterEvent;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationToRecruiterListener
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
     * @param  \App\Events\SendNotificationToRecruiterEvent  $event
     * @return void
     */
    public function handle(SendNotificationToRecruiterEvent $event)
    {
        $data = [
            'to_user_id'        =>  $event->data->user_id,
            'from_user_id'      =>  $event->data->sender_id,
            'notification_type' =>  'JOB_PITCH',
            'title'             =>  $event->data->sender_name ." has sent a pitch for job " .$event->data->title ." ",
            'redirection_id'    =>   $event->data->job_id,
            'description'       => 'JOB PITCH DESCRIPTION',
        ];
        
        $save_notification = app(CreateDBNotification::class)->execute($data);
        return $send_push = app(PushNotificationService::class)->execute($data,$event->data->device_token);
    }
}
