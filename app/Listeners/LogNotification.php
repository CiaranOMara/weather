<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogNotification
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
     * @param  NotificationSent $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        Log::info("Notification sent:", [
            'channel' => $event->channel,
            'response' => $event->response,
            'notifiable' => $event->notifiable,
            'notification' => $event->notification
        ]);

    }
}
