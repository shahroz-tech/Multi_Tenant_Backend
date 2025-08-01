<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;
    public $task;
    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task=$task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
   public function toDatabase(object $notifiable): array{
       return [
           'title' => 'Task Assigned',
           'message' => "Task '{$this->task->title}' has been assigned to you.",
           'task_id' => $this->task->id,
       ];

   }
}
