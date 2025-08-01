<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users
        $users = User::factory()->count(10)->create();

        // Create 3 teams, each owned by a random user
        $teams = Team::factory()
            ->count(3)
            ->sequence(fn () => ['owner_id' => $users->random()->id])
            ->create();

        // Attach users to teams with roles
        foreach ($teams as $team) {
            $members = $users->random(rand(3, 6));

            foreach ($members as $member) {
                $role = $member->id === $team->owner_id ? 'owner' : 'member';

                $team->users()->attach($member->id, ['role' => $role]);
            }
        }
    }
}
