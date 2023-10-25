<?php

namespace Database\Seeders;

use App\Models\Cohort;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();
        foreach ($courses as $course) {
            for ($i = 0; $i < 3; $i++) {
                Cohort::create([
                    'name' => ucfirst(Str::random(8)),
                    'places' => 24,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(18),
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
