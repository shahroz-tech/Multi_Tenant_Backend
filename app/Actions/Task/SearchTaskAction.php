<?php
namespace App\Actions\Task;


use App\Models\Task;

class SearchTaskAction
{
    public function execute(string $query)
    {
        return Task::query()
            ->where('task_name', 'like', "%{$query}%")
            ->orWhere('task_description', 'like', "%{$query}%")
            ->get();
    }
}
