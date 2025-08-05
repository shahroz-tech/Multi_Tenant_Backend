<?php

namespace App\Actions\Task\TaskFile;

use App\Models\ActivityLog;
use App\Models\File;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadTaskFileAction
{
    public function execute(Request $request, Task $task): File
    {
        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store("tasks/{$task->id}", 'public');

        $file = $task->files()->create([
            'file_path' => $path,
            'original_name' => $uploadedFile->getClientOriginalName(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'uploaded',
            'target_type' => 'File',
            'target_id' => $file->id,
        ]);

        return $file;
    }
}
