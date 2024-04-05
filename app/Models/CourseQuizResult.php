<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizResult extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'course_quiz_results';
    protected $fillable  = [
        'id',
        'total_questions',
        'total_correct_answers',
        'time_taken',
        'course_id',
        'student_id'
    ];

    // public function chapters()
    // {
    //     return $this->belongsTo('App\Models\Chapter', 'chapter_id', 'id');
    // }
}
