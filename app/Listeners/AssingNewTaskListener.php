<?php

namespace App\Listeners;

use App\Jobs\AssingTaskJob;
use App\Events\AssignNewTaskEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssingNewTaskListener
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
     * @param  \App\Events\AssignNewTaskEvent  $event
     * @return void
     */
    public function handle(AssignNewTaskEvent $event)
    {
        dispatch(new AssingTaskJob($event->data));
    }
}
