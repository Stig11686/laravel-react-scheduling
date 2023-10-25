<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Session;
use Faker\Factory as Faker;

class SessionsSeeder extends Seeder
{
    public function run()
    {
        $sessions_count = 50;
        $courses = Course::all();
        $faker = Faker::create();

        // Create sessions and associate them with courses
        for ($i = 0; $i < $sessions_count; $i++) {
            $name = $sessionName = trim($faker->sentence(rand(4, 8)));
            $session = Session::create([
                'name' => $name,
            ]);
        }
    }
}
