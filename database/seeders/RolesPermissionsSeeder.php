<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'cohort_access', 'guard_name' => 'web'],
            ['name' => 'cohort_create', 'guard_name' => 'web'],
            ['name' => 'cohort_edit', 'guard_name' => 'web'],
            ['name' => 'cohort_delete', 'guard_name' => 'web'],
            ['name' => 'cohort_show', 'guard_name' => 'web'],
            ['name' => 'course_access', 'guard_name' => 'web'],
            ['name' => 'course_create', 'guard_name' => 'web'],
            ['name' => 'course_edit', 'guard_name' => 'web'],
            ['name' => 'course_delete', 'guard_name' => 'web'],
            ['name' => 'course_show', 'guard_name' => 'web'],
            ['name' => 'session_access', 'guard_name' => 'web'],
            ['name' => 'session_create', 'guard_name' => 'web'],
            ['name' => 'session_edit', 'guard_name' => 'web'],
            ['name' => 'session_delete', 'guard_name' => 'web'],
            ['name' => 'session_show', 'guard_name' => 'web'],
            ['name' => 'instance_access', 'guard_name' => 'web'],
            ['name' => 'instance_create', 'guard_name' => 'web'],
            ['name' => 'instance_edit', 'guard_name' => 'web'],
            ['name' => 'instance_delete', 'guard_name' => 'web'],
            ['name' => 'instance_show', 'guard_name' => 'web'],
            ['name' => 'user_access', 'guard_name' => 'web'],
            ['name' => 'user_create', 'guard_name' => 'web'],
            ['name' => 'user_edit', 'guard_name' => 'web'],
            ['name' => 'user_delete', 'guard_name' => 'web'],
            ['name' => 'user_show', 'guard_name' => 'web'],
            ['name' => 'zoom_access', 'guard_name' => 'web'],
            ['name' => 'zoom_create', 'guard_name' => 'web'],
            ['name' => 'zoom_edit', 'guard_name' => 'web'],
            ['name' => 'zoom_delete', 'guard_name' => 'web'],
            ['name' => 'zoom_show', 'guard_name' => 'web'],
            ['name' => 'funder_access', 'guard_name' => 'web'],
            ['name' => 'funder_create', 'guard_name' => 'web'],
            ['name' => 'funder_edit', 'guard_name' => 'web'],
            ['name' => 'funder_delete', 'guard_name' => 'web'],
            ['name' => 'funder_show', 'guard_name' => 'web'],
            ['name' => 'learner_access', 'guard_name' => 'web'],
            ['name' => 'learner_create', 'guard_name' => 'web'],
            ['name' => 'learner_edit', 'guard_name' => 'web'],
            ['name' => 'learner_delete', 'guard_name' => 'web'],
            ['name' => 'learner_show', 'guard_name' => 'web'],
            ['name' => 'trainer_access', 'guard_name' => 'web'],
            ['name' => 'trainer_create', 'guard_name' => 'web'],
            ['name' => 'trainer_edit', 'guard_name' => 'web'],
            ['name' => 'trainer_delete', 'guard_name' => 'web'],
            ['name' => 'trainer_show', 'guard_name' => 'web'],
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }

        //create roles
        $super_admin = Role::create([
            'name' => 'super-admin'
        ]);

        $admin = Role::create([
            'name' => 'admin'
        ]);

        $trainer = Role::create([
            'name' => 'trainer'
        ]);

        $learner = Role::create([
            'name' => 'learner'
        ]);

        //assign permissions to roles
        $super_admin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $trainer->givePermissionTo([
            'learner_show',
            'zoom_show',
            'instance_show',
            'instance_edit'
        ]);
        $learner->givePermissionTo([
            'instance_show'
        ]);




    }
}
