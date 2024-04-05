<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chapters')->insert([
            [ 
                'number' => 'A01',
                'name' => 'Chapter 1',
                'status'=> '1',
                'state' => '0',
                'total_quiz_time' => 20,
                'subject_id' => 1,
                'grade_id' => 1,
                'created_by'=> 1,
                'created_at' => '2023-09-26 00:00:00'
         ],
         [ 
            'number' => 'A02',
            'name' => 'Chapter 2',
            'status'=> '1',
            'state' => '0',
            'total_quiz_time' => 30,
            'subject_id' => 1,
            'grade_id' => 1,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'number' => 'A03',
            'name' => 'Chapter 1',
            'status'=> '1',
            'state' => '0',
            'total_quiz_time' => 20,
            'subject_id' => 2,
            'grade_id' => 1,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ],
        [ 
            'number' => 'A04',
            'name' => 'Chapter 2',
            'status'=> '1',
            'state' => '0',
            'total_quiz_time' => 20,
            'subject_id' => 2,
            'grade_id' => 1,
            'created_by'=> 1,
            'created_at' => '2023-09-26 00:00:00'
        ]
           
        ]);
    }
}
