<?php

namespace App\Actions\Team;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class DeleteTeamAction
{
    /**
     * @throws AuthorizationException
     */
    public function execute(int $id): void
    {
        $userTeam = Auth::user()->teams()->findOrFail($id);
        if ($userTeam->pivot->role !== 'owner') {
            throw new AuthorizationException('Only the team owner can delete the team.');
        }

        $team = Team::findOrFail($id);
        $team->delete();
    }
}
