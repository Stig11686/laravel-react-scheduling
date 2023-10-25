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
                ZoomRoomsSeeder::class,
                FundersSeeder::class,
                CourseSeeder::class,
                CohortSeeder::class,
                RolesPermissionsSeeder::class,
                UserSeeder::class,
                SessionsSeeder::class,
                TaskSeeder::class,
                CohortSessionSeeder::class
            ]);
    }
}
