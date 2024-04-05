<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuiz extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'course_quizes';
    protected $fillable  = [
        'id',
        'course_id',
        'question_text',
        'question_image',
        'option_a_text',
        'option_a_image',
        'option_b_text',
        'option_b_image',
        'option_c_text',
        'option_c_image',
        'option_d_text',
        'option_d_image',
        'references',
        'difficulty_level',
        'correct_answer',
        'created_by',
        'updated_by'
    ];

    // public function chapters()
    // {
    //     return $this->belongsTo('App\Models\Chapter', 'chapter_id', 'id');
    // }
}
