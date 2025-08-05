<?php

namespace App\Actions\Task\TaskFile;

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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'deleted',
            'target_type' => 'File',
            'target_id' => $file->id,
        ]);
    }
}
