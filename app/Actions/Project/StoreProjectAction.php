<?php

namespace App\Actions\Project;

use App\Models\Project;

class StoreProjectAction
{
    public function handle(array $data): Project
    {
        return Project::create($data);
    }
}
