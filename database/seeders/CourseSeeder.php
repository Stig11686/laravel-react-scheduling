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
            ['name' => 'Crucial Skills for Software Developers'],
            ['name' => 'Crucial Skills for Software Testers'],
            ['name' => 'Essential Skills for Digital Project Managers'],
            ['name' => 'Essential Skills for Agile in Tech'],
            ['name' => 'Essential Skill for UX Professionals'],
            ['name' => 'Level 4 Software Development Apprenticeship'],
            ['name' => 'Level 4 Software Testing Apprenticeship'],
        ];

        foreach($courses as $course){
            Course::create($course);
        }
    }
}
