<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(4, true),
            'review_due' => fake()->dateTimeBetween('-6 week', '+1 year'),
            'review_status' => fake()->randomElement(['Done', 'Review', 'Embedding', 'Basic Set Up']),
            'slides' => fake()->url(),
            'trainer_notes' => fake()->url()
        ];
    }
}
