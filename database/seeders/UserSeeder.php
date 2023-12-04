<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employer;
use App\Models\Learner;
use App\Models\Cohort;
use App\Models\Trainer;

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

        // Create a sample learner with associated cohort and trainer
        $learner = User::create([
            'name' => 'learner',
            'email' => 'steven.marks@bvswebdesign.co.uk',
            'password' => bcrypt('Erding3r!')
        ])->assignRole('learner');

        Learner::create([
            'user_id' => $learner->id,
            'cohort_id' => 1,
            'trainer_id' => 1
        ]);

        $cohort_one = Cohort::find(1);
        $cohort_one->decrement('places');

        // Create learners and assign to cohorts
        $users = User::factory(200)->create([
            'password' => Hash::make('password')
        ]);

        // Assign roles to users
        $this->assignRoles($users);

        // Assign employers, managers, and mentors for learners
        $this->assignEmployersForLearners($users);
    }

    private function assignRoles($users)
    {
        $rolesCount = [
            'learner' => 0.7 * count($users),
            'trainer' => 0.15 * count($users),
            'manager' => 0.1 * count($users),
            'mentor' => 0.05 * count($users),
        ];

        foreach ($rolesCount as $role => $count) {
            $roleUsers = $users->splice(0, $count);
            foreach ($roleUsers as $user) {
                $user->assignRole($role);
            }
        }
    }

    private function assignEmployersForLearners($users)
    {
        $cohorts = Cohort::all();
        foreach ($users->where('hasRole', 'learner') as $user) {
            $cohort = $cohorts->where('places', '>', 0)->random();
            $learner = Learner::create([
                'user_id' => $user->id,
                'cohort_id' => $cohort->id,
                'trainer_id' => 2 // Update with the appropriate trainer ID
            ]);

            $cohort->decrement('places');

            if ($cohort->course->course_type->name === 'Apprenticeship') {
                $employer = Employer::inRandomOrder()->first();
                $user->learner->employer_id = $employer->id;
                $user->learner->save();
            }
        }
    }
}
