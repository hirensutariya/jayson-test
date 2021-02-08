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
                'name'=>"Country View",
                'slug'=>"countries.view",
            ],
            [
                'name'=>"Country Create",
                'slug'=>"countries.create",
            ],            
            [
                'name'=>"Country Update",
                'slug'=>"countries.update",
            ],
            [
                'name'=>"Country Delete",
                'slug'=>"countries.delete",
            ],

            [
                'name'=>"State View",
                'slug'=>"states.view",
            ],
            [
                'name'=>"State Create",
                'slug'=>"states.create",
            ],            
            [
                'name'=>"State Update",
                'slug'=>"states.update",
            ],
            [
                'name'=>"State Delete",
                'slug'=>"states.delete",
            ],

            [
                'name'=>"City View",
                'slug'=>"cities.view",
            ],
            [
                'name'=>"City Create",
                'slug'=>"cities.create",
            ],            
            [
                'name'=>"City Update",
                'slug'=>"cities.update",
            ],
            [
                'name'=>"City Delete",
                'slug'=>"cities.delete",
            ],

            [
                'name'=>"Department View",
                'slug'=>"departments.view",
            ],
            [
                'name'=>"Department Create",
                'slug'=>"departments.create",
            ],            
            [
                'name'=>"Department Update",
                'slug'=>"departments.update",
            ],
            [
                'name'=>"Department Delete",
                'slug'=>"departments.delete",
            ],

            [
                'name'=>"Employee View",
                'slug'=>"employee.view",
            ],
            [
                'name'=>"Employee Create",
                'slug'=>"employee.create",
            ],            
            [
                'name'=>"Employee Update",
                'slug'=>"employee.update",
            ],
            [
                'name'=>"Employee Delete",
                'slug'=>"employee.delete",
            ],

            [
                'name'=>"User View",
                'slug'=>"user.view",
            ],
            [
                'name'=>"User Create",
                'slug'=>"user.create",
            ],            
            [
                'name'=>"User Update",
                'slug'=>"user.update",
            ],
            [
                'name'=>"User Delete",
                'slug'=>"user.delete",
            ],

            [
                'name'=>"Role View",
                'slug'=>"role.view",
            ],
            [
                'name'=>"Role Create",
                'slug'=>"role.create",
            ],            
            [
                'name'=>"Role Update",
                'slug'=>"role.update",
            ],
            [
                'name'=>"Role Delete",
                'slug'=>"role.delete",
            ],

            [
                'name'=>"Permission View",
                'slug'=>"permission.view",
            ],
            [
                'name'=>"Permission Create",
                'slug'=>"permission.create",
            ],            
            [
                'name'=>"Permission Update",
                'slug'=>"permission.update",
            ],
            [
                'name'=>"Permission Delete",
                'slug'=>"permission.delete",
            ],

        ];

        DB::table('permissions')->insert($permissionList);
    }
}
