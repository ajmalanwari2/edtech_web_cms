<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schools')->insert([
            [ 
                'number' => 'A01',
                'name' => 'Afghan School',
                'status'=> '1',
                'regional_management_office_id' => 1,
                'province_id' => 1,
                'district_id' => 1,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
         ],
         [ 
                'number' => 'A02',
                'name' => 'Abdul Ali Mustaghni High School',
                'status'=> '1',
                'regional_management_office_id' => 1,
                'province_id' => 1,
                'district_id' => 3,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
                'number' => 'A03',
                'name' => 'Abdul Hadi Dawi High School',
                'status'=> '1',
                'regional_management_office_id' => 1,
                'province_id' => 1,
                'district_id' => 2,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
                'number' => 'A04',
                'name' => 'Abdul Qadir Shahid High School',
                'status'=> '1',
                'regional_management_office_id' => 1,
                'province_id' => 1,
                'district_id' => 5,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
        ]
           
        ]);

        DB::table('grades_in_schools')->insert([
            [ 
                'school_id' => 1,
                'grade_id' => 1,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
         ],
         [ 
            'school_id' => 1,
            'grade_id' => 2,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 1,
                'grade_id' => 3,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 2,
            'grade_id' => 2,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 2,
            'grade_id' => 1,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 3,
            'grade_id' => 1,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 4,
            'grade_id' => 1,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 4,
                'grade_id' => 2,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'school_id' => 4,
                'grade_id' => 3,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
        ]
           
        ]);
    }
}
