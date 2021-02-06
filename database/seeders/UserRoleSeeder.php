<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->delete();

        $userRoleList = [
            [
                'user_id' => User::first()->id,
                'role_id' => Role::first()->id
            ]
        ];

        DB::table('users_roles')->insert($userRoleList);
    }
}
