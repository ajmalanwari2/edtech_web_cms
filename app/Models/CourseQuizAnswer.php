<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizAnswer extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'course_quiz_answers';
    protected $fillable  = [
        'id',
        'question_id',
        'answer',
        'created_by'
    ];

    // public function chapters()
    // {
    //     return $this->belongsTo('App\Models\Chapter', 'chapter_id', 'id');
    // }
}
