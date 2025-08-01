<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 teams
        Team::factory()
            ->count(5)
            ->create()
            ->each(function ($team) {
                // For each team, create 3 projects
                Project::factory()
                    ->count(3)
                    ->create([
                        'team_id' => $team->id
                    ]);
            });
    }
}
