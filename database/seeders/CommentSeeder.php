<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::all()->each(function ($task) {
            Comment::factory()->count(3)->create([
                'task_id' => $task->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        });
    }
}
