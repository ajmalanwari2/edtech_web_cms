<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subject_lessons')->insert([
            [ 
                'chapter_id' => 1,
                'title' => 'Subtraction',
                'body'=> 'https://www.youtube.com/watch?v=VRoTOE3FqT0',
                'type' => 'video',
                'created_by'=> 1
         ],
         [ 
            'chapter_id' => 1,
                'title' => 'Number',
                'body'=> 'storage/uploads/file/1-1705400580.pdf',
                'type' => 'file',
                'created_by'=> 1
        ],
        [ 
            'chapter_id' => 1,
                'title' => 'Addition',
                'body'=> 'Addition is one of the four basic operations of arithmetic, the other three being subtraction, multiplication and division.',
                'type' => 'text',
                'created_by'=> 1
        ],
        [ 
            'chapter_id' => 2,
            'title' => 'Subtraction',
            'body'=> 'https://www.youtube.com/watch?v=VRoTOE3FqT0',
            'type' => 'video',
            'created_by'=> 1
     ],
     [ 
        'chapter_id' => 2,
            'title' => 'Number',
            'body'=> 'storage/uploads/file/1-1705400580.pdf',
            'type' => 'file',
            'created_by'=> 1
    ],
    [ 
        'chapter_id' => 2,
            'title' => 'Addition',
            'body'=> 'Addition is one of the four basic operations of arithmetic, the other three being subtraction, multiplication and division.',
            'type' => 'text',
            'created_by'=> 1
    ]
           
        ]);
    }
}
