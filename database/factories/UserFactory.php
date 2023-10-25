<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function randomEmailGenerator(){
        $emailProviders = ['aol', 'yahoo', 'gmail', 'hotmail'];
        $suffixes = ['.co.uk', '.com', '.org', '.io', 'ie', '.de', '.in', '.net'];

        return $emailProviders[array_rand($emailProviders, 1)] . $suffixes[array_rand($suffixes, 1)];
    }

    private function slugify($string){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -]+/', '', $string);
        $string = str_replace(' ', '-', $string);
        return trim($string);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('learner');
        });
    }
}
