<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Events\TaskAssignedEvent;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskAssignController extends Controller
{
    public function assign(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $task->users()->syncWithoutDetaching($request->user_id);

        $task = Task::with('users')->findOrFail($task->id);

        event(new TaskAssignedEvent($task));


        return response()->json([
            'message' => 'Task assigned successfully',
            'task' => $task->load('users'),
        ]);
    }
}
