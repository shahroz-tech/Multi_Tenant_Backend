<?php
namespace App\Actions\Project;

use App\Models\Project;

class RestoreProjectAction
{
    public function handle(int $id): Project
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();
        return $project;
    }
}
