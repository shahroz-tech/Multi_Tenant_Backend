<?php

namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class StoreProjectAction
{
    public function handle(array $data): Project
    {
        return Project::create([
            'user_id'=> Auth::id(),
            'team_id'=> $data["team_id"],
            'project_name'=> $data["project_name"],
            'project_description'=> $data["project_description"]
        ]);
    }
}
