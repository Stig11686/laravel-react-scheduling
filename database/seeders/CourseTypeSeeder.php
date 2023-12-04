<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseType;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course_types = [
            ['name' => 'Apprenticeship'],
            ['name' => 'Bootcamp']
        ];

        foreach($course_types as $type){
            CourseType::create($type);
        }
    }
}
