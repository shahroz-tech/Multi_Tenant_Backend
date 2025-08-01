<?php

namespace App\Actions\Team;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateTeamAction
{
    /**
     * @throws AuthorizationException
     */
    public function execute(int $id, array $validated): Team
    {
        $userTeam = Auth::user()->teams()->findOrFail($id);
        if ($userTeam->pivot->role !== 'owner') {
            throw new AuthorizationException('Only the team owner can update the team.');
        }

        $team = Team::findOrFail($id);
        $team->update([
            'team_name' => $validated['team_name'],
            'team_description' => $validated['team_description'] ?? null,
        ]);

        return $team;
    }
}
