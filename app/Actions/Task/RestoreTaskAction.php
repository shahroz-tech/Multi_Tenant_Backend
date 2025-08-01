<?php


namespace App\Actions\Task;

use App\Models\Task;

class RestoreTaskAction
{
    public function handle(int $id): Task
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();
        return $task;
    }
}
