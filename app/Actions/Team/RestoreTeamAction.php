<?php

namespace App\Actions\Team;

use App\Models\Team;

class RestoreTeamAction
{
    public function execute(int $id): Team
    {
        $team = Team::onlyTrashed()->findOrFail($id);
        $team->restore();

        return $team;
    }
}
