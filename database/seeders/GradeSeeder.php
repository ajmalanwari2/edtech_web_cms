<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grades')->insert([
            [ 
                'number' => 'A01',
                'name' => 'Grade 1',
                'status'=> '1',
                'created_by'=> 1
         ],
         [ 
                'number' => 'A02',
                'name' => 'Grade 2',
                'status'=> '1',
                'created_by'=> 1
        ],
        [ 
                'number' => 'A03',
                'name' => 'Grade 3',
                'status'=> '1',
                'created_by'=> 1
        ],
        [ 
            'number' => 'A04',
            'name' => 'Grade 4',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A05',
            'name' => 'Grade 5',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A06',
            'name' => 'Grade 6',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A07',
            'name' => 'Grade 7',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A08',
            'name' => 'Grade 8',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A09',
            'name' => 'Grade 9',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A10',
            'name' => 'Grade 10',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A11',
            'name' => 'Grade 11',
            'status'=> '1',
            'created_by'=> 1
        ],
        [ 
            'number' => 'A12',
            'name' => 'Grade 12',
            'status'=> '1',
            'created_by'=> 1
        ]
           
        ]);

        DB::table('subjects_in_grades')->insert([
            [ 
                'grade_id' => 1,
                'subject_id' => 1,
                'created_by'=> 1
         ],
         [ 
                'grade_id' => 1,
                'subject_id' => 2,
                'created_by'=> 1
        ],
        [ 
            'grade_id' => 2,
            'subject_id' => 3,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 2,
            'subject_id' => 2,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 2,
                'subject_id' => 4,
                'created_by'=> 1
        ],
        [ 
            'grade_id' => 3,
                'subject_id' => 1,
                'created_by'=> 1
        ],
        [ 
            'grade_id' => 4,
            'subject_id' => 4,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 5,
            'subject_id' => 3,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 6,
                'subject_id' => 2,
                'created_by'=> 1
        ],
        [ 
            'grade_id' => 6,
            'subject_id' => 1,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 7,
            'subject_id' => 3,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 8,
            'subject_id' => 4,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 9,
            'subject_id' => 3,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 10,
            'subject_id' => 4,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 11,
            'subject_id' => 4,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 12,
            'subject_id' => 2,
            'created_by'=> 1
        ],
        [ 
            'grade_id' => 12,
            'subject_id' => 4,
            'created_by'=> 1
        ]
           
        ]);
    }
}
