<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(), // default if not provided
            'task_name' => $this->faker->sentence(3),
            'task_description' => fake()->catchPhrase(),
            'task_status' => $this->faker->randomElement(['todo', 'in_progress', 'completed']),
            'task_priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'task_due_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'task_labels' => json_encode($this->faker->words(3)),
        ];
    }
}
