<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure you have users and tasks in the database
        if (User::count() === 0 || Task::count() === 0) {
            $this->command->error('Seed users and tasks before running this seeder.');
            return;
        }

        $users = User::all();

        Task::all()->each(function ($task) use ($users) {
            // Attach 1–3 random users to each task
            $task->users()->attach(
                $users->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
