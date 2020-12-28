<?php

namespace App\Listeners;


use App\Events\SendNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApplySendNotification
{


    public function __construct()
    {
        //
    }

    public function handle(SendNotification $event)
    {
        PostRequests($event->data);
    }
}
