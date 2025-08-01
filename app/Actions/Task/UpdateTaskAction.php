<?php


namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateTaskAction
{
    public function handle(Request $request, Task $task): Task|\Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_status' => 'nullable|in:todo,in_progress,completed',
            'task_priority' => 'nullable|in:low,medium,high',
            'task_due_date' => 'nullable|date',
            'task_labels' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task->update([
            'task_name' => $request->task_name ?? $task->task_name,
            'task_description' => $request->task_description ?? $task->task_description,
            'task_status' => $request->task_status ?? $task->task_status,
            'task_priority' => $request->task_priority ?? $task->task_priority,
            'task_due_date' => $request->task_due_date ?? $task->task_due_date,
            'task_labels' => $request->task_labels ? json_encode($request->task_labels) : $task->task_labels,
        ]);

        return $task;
    }
}
