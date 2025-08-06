<?php

namespace App\Http\Controllers\Api\V1\Project;

use App\Actions\Project\DeleteProjectAction;
use App\Actions\Project\RestoreProjectAction;
use App\Actions\Project\StoreProjectAction;
use App\Actions\Project\UpdateProjectAction;
use App\Events\ProjectUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function index()
    {
        return auth()->user()->projects()->with('user','team','tasks')->get();
    }

    public function show(Request $request, Project $project)
    {
        return auth()->user()->projects()->where('id',$project->id)->first();
    }

    public function store(Request $request, StoreProjectAction $storeAction, ActivityLogService $log)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'project_name' => 'required|string|max:255',
            'project_description' => 'required|string',
        ]);

        $project = $storeAction->handle($validated);
        $log->log('created', 'Project', $project->id);

        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project, UpdateProjectAction $updateAction, ActivityLogService $log)
    {
        $validated = $request->validate([
            'project_name' => 'sometimes|required|string|max:255',
            'project_description' => 'sometimes|required|string',
        ]);

        $log->log('updated', 'Project', $project->id);
        $updatedProject = $updateAction->handle($project, $validated);

        event(new ProjectUpdatedEvent($updatedProject));

        return response()->json($updatedProject);
    }

    public function destroy(Project $project, DeleteProjectAction $deleteProjectAction)
    {
        $deleteProjectAction->handle($project);

        return response()->json(['message' => 'Project deleted']);
    }

    public function restore($id, RestoreProjectAction $restoreProjectAction)
    {
        $project = $restoreProjectAction->handle($id);

        return response()->json(['message' => 'Project restored successfully.']);
    }
}
