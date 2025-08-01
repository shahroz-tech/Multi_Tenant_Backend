<?php


namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreTaskAction
{
    public function handle(Request $request): Task|\Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
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

        $data = $request->only([
            'project_id', 'task_name', 'task_description',
            'task_status', 'task_priority', 'task_due_date'
        ]);

        $data['task_labels'] = $request->task_labels ? json_encode($request->task_labels) : null;

        return Task::create($data);
    }
}
