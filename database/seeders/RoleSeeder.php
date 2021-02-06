<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roleList = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin'
            ],
            [
                'name' => 'System Admin',
                'slug' => 'system-admin'
            ],
            [
                'name' => 'Employee Management',
                'slug' => 'employee-management'
            ],
            [
                'name' => 'User Management',
                'slug' => 'user-management'
            ]
        ];

        DB::table('roles')->insert($roleList);
    }
}
