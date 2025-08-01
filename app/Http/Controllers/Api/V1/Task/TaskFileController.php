<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\File;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskFileController extends Controller
{
    public function upload(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store("tasks/{$task->id}", 'public');

        $file = $task->files()->create([
            'file_path' => $path,
            'original_name' => $uploadedFile->getClientOriginalName(),
        ]);

        //Activity log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'uploaded',
            'target_type' => 'File',
            'target_id' => $file->id,
        ]);


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

    public function destroy(Task $task, File $file)
    {
        if ($file->task_id !== $task->id) {
            return response()->json(['message' => 'Invalid file for task'], 403);
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        //Activity log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => 'deleted',
            'target_type' => 'File',
            'target_id' => $file->id,
        ]);


        return response()->json(['message' => 'File deleted']);
    }

    //restore endpoint
    public function restore($id)
    {
        $task = File::onlyTrashed()->findOrFail($id);
        $task->restore();

        return response()->json(['message' => 'File restored successfully.']);
    }
}
