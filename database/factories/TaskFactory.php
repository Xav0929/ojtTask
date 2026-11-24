<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
           'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'title'       => fake()->randomElement([
                'Finish Laravel routing notes',
                'Submit project report',
                'Buy groceries',
                'Review database relationships',
                'Prepare for quiz',
                'Clean the room',
                'Call the dentist',
                'Read chapter 5',
                'Update the README',
                'Plan weekend trip',
                'Pay electricity bill',
                'Practice Blade components',
            ]),
            'description' => fake()->randomElement([
                'Review and write short notes.',
                'Finish before the deadline.',
                'Do this after class.',
                'Ask a classmate if stuck.',
                'Quick task, about 30 minutes.',
                'Remember to double check.',
            ]),
            'status'      => fake()->randomElement(['pending', 'done']),
            'priority'    => fake()->randomElement(['low', 'medium', 'high']),
            'due_date'    => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
