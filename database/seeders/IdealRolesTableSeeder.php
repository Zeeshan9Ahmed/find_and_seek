<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IdealRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ideal_roles')->delete();
        
        \DB::table('ideal_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_name' => 'Role 1',
                'created_at' => '2022-11-24 18:36:03',
                'updated_at' => '2022-11-17 18:36:03',
            ),
            1 => 
            array (
                'id' => 2,
                'role_name' => 'Role 2',
                'created_at' => '2022-11-24 18:36:03',
                'updated_at' => '2022-11-17 18:36:03',
            ),
            2 => 
            array (
                'id' => 3,
                'role_name' => 'Role 3',
                'created_at' => '2022-11-24 18:36:03',
                'updated_at' => '2022-11-17 18:36:03',
            ),
            3 => 
            array (
                'id' => 4,
                'role_name' => 'Role 4',
                'created_at' => '2022-11-24 18:36:03',
                'updated_at' => '2022-11-17 18:36:03',
            ),
        ));
        
        
    }
}