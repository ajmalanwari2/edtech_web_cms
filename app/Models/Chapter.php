<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'number', 'name', 'total_quiz_time', 'visible_question', 'state', 'grade_id', 'subject_id', 'status', 'created_by', 'updated_by'];


    public function grades()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id', 'id');
    }

    public function subjects()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }


    public function contents()
    {
        return $this->hasMany('App\Models\Content');
    }

    public function loadContents()
    {
        $this->load('contents');
    }

}
