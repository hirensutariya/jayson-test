<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Sentinel;

class Superadmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Sentinel::registerAndActivate([
            'first_name'    => 'Super Admin',
            'last_name'    => 'Super Admin',
            'username'    => 'superadmin',
            'email'    => 'superadmin@gmail.com',
            'password' => 'admin@123',
        ]);

        $role = Sentinel::findRoleByName('Super Admin');
        $role->users()->attach($user);

        $user->permissions = [
            "countries.view" => true,
            "countries.create" => true,
            "countries.update" => true,
            "countries.delete" => true,

            "states.view" => true,
            "states.create" => true,
            "states.update" => true,
            "states.delete" => true,

            "cities.view" => true,
            "cities.create" => true,
            "cities.update" => true,
            "cities.delete" => true,

            "departments.view" => true,
            "departments.create" => true,
            "departments.update" => true,
            "departments.delete" => true,

            "employee.view" => true,
            "employee.create" => true,
            "employee.update" => true,
            "employee.delete" => true,

            "user.view" => true,
            "user.create" => true,
            "user.update" => true,
            "user.delete" => true,

            "role.view" => true,
            "role.create" => true,
            "role.update" => true,
            "role.delete" => true,

            "permission.view" => true,
            "permission.create" => true,
            "permission.update" => true,
            "permission.delete" => true,
        ];

        $user->save();
    }
}
