<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'email' => fake()->unique()->safeEmail,
            'phone' => $this->uniquePhoneNumber(),
            'is_levy' => false
        ];
    }

    public function uniquePhoneNumber()
    {
        $phoneNumber = '07';
        for ($i = 0; $i < 9; $i++) {
            $phoneNumber .= mt_rand(0, 9);
        }

        // Ensure the generated number is unique in your database
        $existingPhoneNumbers = Employer::pluck('phone')->toArray();
        while (in_array($phoneNumber, $existingPhoneNumbers)) {
            $phoneNumber = '07';
            for ($i = 0; $i < 9; $i++) {
                $phoneNumber .= mt_rand(0, 9);
            }
        }

        return $phoneNumber;
    }
}
