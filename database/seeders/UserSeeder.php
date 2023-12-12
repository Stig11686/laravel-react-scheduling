<?php

namespace Database\Seeders;

use App\Models\Cohort;
use App\Models\Learner;
use App\Models\Trainer;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $cohorts = Cohort::all();
        $employers = Employer::all();
        $num_trainers = 20;
        $num_learners = 150;
        $num_staff = 30;

        // Create super users
        $this->create_super_users();

        //create our users
        $users = $this->create_users();

        //Assign an employer a manager
        $this->assign_employer_a_manager($users, $employers, $num_staff);

        //Create some trainers
        $this->create_trainers($users, $num_staff, $num_trainers);

        $this->create_learners($cohorts, $users, $employers, $num_staff, $num_learners, $num_trainers);
    }

    private function create_learners($cohorts, $users, $employers, $num_staff, $num_learners, $num_trainers)
    {
        $learnerUsers = $users->skip($num_trainers + $num_staff)->take($num_learners);
        $trainerUsers = Trainer::all();

        foreach ($learnerUsers as $learnerUser) {
            $cohort = $cohorts->where('places', '>', 0)->random();
            $employer = $employers->random();
            $manager = $employer->managers()->inRandomOrder()->first();
            // $mentor = $employer->mentors()->inRandomOrder()->first();
            $trainer = $trainerUsers->random();

            // Create Learner
            $learner = Learner::create([
                'user_id' => $learnerUser->id,
                'cohort_id' => $cohort->id,
                'trainer_id' => $trainer->id,
                'manager_id' => $manager->id,
            ]);

            // Assign Employer
            $learnerUser->employer_id = $employer->id;

            $learnerUser->save();

            $cohort->decrement('places');
            $learnerUser->assignRole('learner');
        }
    }


    private function create_trainers($users, $num_staff, $num_trainers)
    {
       $trainerUsers = $users->skip($num_staff)->take($num_trainers);
        foreach ($trainerUsers as $user) {
            Trainer::create([
                'user_id' => $user->id,
                'has_dbs' => 1
            ]);
            $user->assignRole('trainer');
        }
    }

    private function assign_employer_a_manager($users, $employers, $num_staff)
    {
        $staffUsers = $users->take($num_staff);

        foreach ($employers as $employer) {
            $existingManager = User::where('employer_id', $employer->id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'manager');
                })
                ->first();

            if (!$existingManager) {
                $userWithoutEmployer = $staffUsers->where('employer_id', null)->random();

                if ($userWithoutEmployer) {
                    // Log or output here to see information about $employer, $userWithoutEmployer, etc.
                    echo $employer, $userWithoutEmployer;

                    $userWithoutEmployer->assignRole('manager');
                    $userWithoutEmployer->employer_id = $employer->id;
                    $userWithoutEmployer->save();
                }
            }
        }
    }

    private function create_super_users(){
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
    }

    private function create_users(){
        $users = User::factory(250)->create([
            'password' => Hash::make('password')
        ]);

        return $users;
    }
}
