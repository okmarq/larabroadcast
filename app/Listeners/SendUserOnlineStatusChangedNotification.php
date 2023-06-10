<?php

namespace App\Listeners;

use App\Events\UserOnlineStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserOnlineStatusChangedNotification
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
    public function handle(UserOnlineStatusChanged $event): UserOnlineStatusChanged
    {
        return $event;
    }
}
