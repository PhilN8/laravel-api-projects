<?php

namespace Database\Factories;

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
        $isCompleted = $this->faker->boolean(80);

        return [
            'title' => $this->faker->words(rand(2, 5), true),
            'description' => $this->faker->paragraph(1),
            'completed' => $isCompleted,
            'completed_at' => $isCompleted ? $this->faker->dateTime() : null
        ];
    }
}
