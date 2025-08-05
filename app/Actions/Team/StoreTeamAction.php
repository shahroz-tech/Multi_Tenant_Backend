<?php


namespace App\Actions\Team;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class StoreTeamAction
{
    public function execute(array $validated): Team
    {
        $user = Auth::user();

        $team = Team::create([
            'team_name' => $validated['team_name'],
            'team_description' => $validated['team_description'] ?? null,
            'owner_id' => $user->id,
        ]);

        $team->users()->attach($user->id, ['role' => 'owner']);

        return $team;
    }
}
