<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        $permissionList = [
            [
                'name' => 'System Management',
                'slug' => 'system-management'
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

        DB::table('permissions')->insert($permissionList);
    }
}
