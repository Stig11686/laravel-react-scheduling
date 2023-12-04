<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses =[
            ['name' => 'Crucial Skills for Software Developers', 'course_type_id' => 2],
            ['name' => 'Crucial Skills for Software Testers', 'course_type_id' => 2],
            ['name' => 'Essential Skills for Digital Project Managers', 'course_type_id' => 2],
            ['name' => 'Essential Skills for Agile in Tech', 'course_type_id' => 2],
            ['name' => 'Essential Skill for UX Professionals', 'course_type_id' => 2],
            ['name' => 'Level 4 Software Development Apprenticeship', 'course_type_id' => 1],
            ['name' => 'Level 4 Software Testing Apprenticeship', 'course_type_id' => 1],
            ['name' => 'Level 4 DevOps Apprenticeship', 'course_type_id' => 1],
            ['name' => 'Level 4 Accessibility Apprenticeship', 'course_type_id' => 1],
        ];

        foreach($courses as $course){
            Course::create($course);
        }
    }
}
