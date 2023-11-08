<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LevelOfEducationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('level_of_education')->delete();
        
        \DB::table('level_of_education')->insert(array (
            0 => 
            array (
                'id' => 1,
                'education_name' => 'Level 1',
                'created_at' => '2022-11-24 18:38:06',
                'updated_at' => '2022-11-16 18:38:06',
            ),
            1 => 
            array (
                'id' => 2,
                'education_name' => 'Level 2',
                'created_at' => '2022-11-24 18:38:06',
                'updated_at' => '2022-11-16 18:38:06',
            ),
            2 => 
            array (
                'id' => 3,
                'education_name' => 'Level 3',
                'created_at' => '2022-11-24 18:38:06',
                'updated_at' => '2022-11-16 18:38:06',
            ),
            3 => 
            array (
                'id' => 4,
                'education_name' => 'Level 4',
                'created_at' => '2022-11-24 18:38:06',
                'updated_at' => '2022-11-16 18:38:06',
            ),
        ));
        
        
    }
}