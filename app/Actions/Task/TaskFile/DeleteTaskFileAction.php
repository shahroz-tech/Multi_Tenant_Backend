<?php

namespace App\Actions\Task\TaskFile;

use App\Actions\Activity\LogActivityAction;
use App\Models\ActivityLog;
use App\Models\File;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteTaskFileAction
{
    public function execute(Task $task, File $file): void
    {
        if ($file->task_id !== $task->id) {
            abort(403, 'Invalid file for task');
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();


    }
}
