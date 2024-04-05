<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [ 
                'number' => 'A01',
                'name' => 'Math',
                'status'=> '1',
                'created_by'=> 1
         ],
         [ 
                'number' => 'A02',
                'name' => 'Biology',
                'status'=> '1',
                'created_by'=> 1
        ],
        [ 
                'number' => 'A03',
                'name' => 'Computer',
                'status'=> '1',
                'created_by'=> 1
        ],
        [ 
            'number' => 'A04',
            'name' => 'English',
            'status'=> '1',
            'created_by'=> 1
        ],
           
        ]);
    }
}