<?php

namespace App\Listeners;

use App\Events\ProjectUpdatedEvent;
use App\Notifications\ProjectUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProjectUpdatedListener
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
    public function handle(ProjectUpdatedEvent $event): void
    {
        $teamMembers = $event->project->team->users; // assuming relationship exists

        foreach ($teamMembers as $teamMember) {
            $teamMember->notify(new ProjectUpdatedNotification($event->project));
        }
    }
}
