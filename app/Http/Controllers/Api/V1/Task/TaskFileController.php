<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Actions\Task\TaskFile\DeleteTaskFileAction;
use App\Actions\Task\TaskFile\RestoreTaskFileAction;
use App\Actions\Task\TaskFile\UploadTaskFileAction;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\File;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskFileController extends Controller
{
    public function upload(Request $request, Task $task, UploadTaskFileAction $action)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $file = $action->execute($request, $task);

        return response()->json([
            'message' => 'File uploaded',
            'file' => [
                'id' => $file->id,
                'name' => $file->original_name,
                'url' => $file->file_path,
            ]
        ]);
    }

    public function list(Task $task)
    {
        return response()->json($task->files->map(function ($file) {
            return [
                'id' => $file->id,
                'name' => $file->original_name,
                'url' => $file->file_path,
            ];
        }));
    }

    public function destroy(Task $task, File $file, DeleteTaskFileAction $action)
    {
        $action->execute($task, $file);

        return response()->json(['message' => 'File deleted']);
    }

    public function restore($id, RestoreTaskFileAction $action)
    {
        $action->execute($id);

        return response()->json(['message' => 'File restored successfully.']);
    }


}
