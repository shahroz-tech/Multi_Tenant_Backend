<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Actions\Task\DeleteTaskAction;
use App\Actions\Task\RestoreTaskAction;
use App\Actions\Task\StoreTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request, StoreTaskAction $storeTaskAction)
    {
        $task = $storeTaskAction->handle($request);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function update(Request $request, string $id, UpdateTaskAction $updateTaskAction)
    {
        $task = Task::findOrFail($id);
        $updatedTask = $updateTaskAction->handle($request, $task);

        return response()->json(['message' => 'Task updated successfully', 'task' => $updatedTask]);
    }

    public function destroy(string $id, DeleteTaskAction $deleteTaskAction)
    {
        $task = Task::findOrFail($id);
        $deleteTaskAction->handle($task);

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function restore($id, RestoreTaskAction $restoreTaskAction)
    {
        $task = $restoreTaskAction->handle($id);

        return response()->json(['message' => 'Task restored successfully.']);
    }
}
