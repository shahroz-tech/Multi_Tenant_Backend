<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Task::factory(20)->create();
        $this->call([
            UserTeamSeeder::class,
            UserTaskSeeder::class,
            TeamProjectSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
