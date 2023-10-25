<?php

namespace Database\Seeders;

use App\Models\Cohort;
use App\Models\Learner;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create super admin
        User::create([
            'name' => 'Steve',
            'email' => 'stevenmarks75@gmail.com',
            'password' => bcrypt('Erding3r!')
        ])->assignRole('super-admin');

        // Create admin
        User::create([
            'name' => 'admin',
            'email' => 'steve@thecodersguild.org.uk',
            'password' => bcrypt('Erding3r!')
        ])->assignRole('admin');

        // Create trainer
        $trainer = User::create([
            'name' => 'trainer',
            'email' => 'info@bvswebdesign.co.uk',
            'password' => bcrypt('Erding3r!')
        ])->assignRole('trainer');

        Trainer::create([
            'user_id' => $trainer->id
        ]);

        $trainer = User::create([
            'name' => 'learner',
            'email' => 'steven.marks@bvswebdesign.co.uk',
            'password' => bcrypt('Erding3r!')
        ])->assignRole('learner');

        Learner::create([
            'user_id' => $trainer->id,
            'cohort_id' => 1
        ]);

        $cohort_one = Cohort::find(1);
        $cohort_one->decrement('places');

        // Create learners and assign to cohorts
        $cohorts = Cohort::all();
        $users = User::factory(200)->create([
            'password' => Hash::make('password')
        ]);
        $learnerUsers = $users->skip(20)->take(180);
        foreach ($learnerUsers as $user) {
            // Create a learner entry
            $cohort = $cohorts->where('places', '>', 0)->random();
            $learner = Learner::create([
                'user_id' => $user->id,
                'cohort_id' => $cohort->id
            ]);

            $cohort->decrement('places');
            $user->assignRole('learner');
        }

        // Create trainer users
        $trainerUsers = $users->take(20);
        foreach ($trainerUsers as $user) {
            Trainer::create([
                'user_id' => $user->id,
                'has_dbs' => 1
            ]);
            $user->assignRole('trainer');
        }
    }
}


