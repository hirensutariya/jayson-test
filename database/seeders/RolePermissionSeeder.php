<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_permissions')->delete();

        $superAdmin = Role::first();

        $permissionList = [];

        foreach(Permission::get() as $permisssion)
        {
            $permissionList = [
                [
                    'role_id' => $superAdmin->id,
                    'permission_id' => $permisssion->id
                ]
            ];
            DB::table('roles_permissions')->insert($permissionList);
        }
    }
}
