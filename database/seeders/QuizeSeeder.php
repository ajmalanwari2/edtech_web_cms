<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class QuizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quizes')->insert([
            [ 
                'chapter_id' => 1,
                'question_text' => 'Let one of the numbers be “x”; then the other is “x+5” ?',
                'difficulty_level'=> 'hard',
                'option_a_text' => 'x + x+5 = 19',
                'option_b_text' => '2x = 14',
                'option_c_text' => 'x = 7 (the 1st number)',
                'option_d_text' => 'x+5 = 12 (the other number)',
                'references' => '1,2',
                'correct_answer' => 'b',
                'created_by'=> 1
         ],
         [ 
            'chapter_id' => 1,
            'question_text' => 'number exceeds another number by 5.the sum of the numbers is 19. find the smaller number ?',
            'difficulty_level'=> 'medium',
            'option_a_text' => '5',
            'option_b_text' => '6',
            'option_c_text' => '12',
            'option_d_text' => '10',
            'references' => '1',
            'correct_answer' => 'a',
            'created_by'=> 1
        ],
        [ 
            'chapter_id' => 2,
            'question_text' => 'What is the Arithmetic Mean of the following data 3,6,9,12,15.?',
            'difficulty_level'=> 'easy',
            'option_a_text' => '7',
            'option_b_text' => '9',
            'option_c_text' => '12',
            'option_d_text' => '8',
            'references' => '2',
            'correct_answer' => 'd',
            'created_by'=> 1
        ],
        [ 
            'chapter_id' => 2,
            'question_text' => 'Find two number whose sum is 28 and the difference is 4 _____________?',
            'difficulty_level'=> 'easy',
            'option_a_text' => '12,16',
            'option_b_text' => '18,10',
            'option_c_text' => '15,13',
            'option_d_text' => '14,12',
            'references' => '1',
            'correct_answer' => 'a',
            'created_by'=> 1
     ]
           
        ]);
    }
}
