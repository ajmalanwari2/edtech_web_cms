<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectInGrade extends Model
{
    use HasFactory;
    public $timestamps = true;

    public $table = 'subjects_in_grades';

    protected $fillable  = ['grade_id', 'subject_id', 'created_by'];


    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function gradeId()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id', 'id')->get();
    }
    public function subjectId()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
}
