<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


            $this->call([
                CourseTypeSeeder::class,
                ZoomRoomsSeeder::class,
                FundersSeeder::class,
                CourseSeeder::class,
                CohortSeeder::class,
                RolesPermissionsSeeder::class,
                EmployerSeeder::class,
                UserSeeder::class,
                SessionsSeeder::class,
                TaskSeeder::class,
                CohortSessionSeeder::class,
                SessionTaskSeeder::class
            ]);
    }
}
