<?php

namespace App\Listeners;

use App\Events\CommentAddedEvent;
use App\Notifications\CommentAddedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CommentAddedListener
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
    public function handle(CommentAddedEvent $event)
    {
//        dd($event->comment->task->user);
        $task = $event->comment->task;
        $assignedUsers = $task->users; // assuming relationship exists

        foreach ($assignedUsers as $assignedUser) {
            Log::info('sending...');
            $assignedUser->notify(new CommentAddedNotification($event->comment));
        }
    }
}
