<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name','description', 'status',  'icon',  'state','total_quiz_time', 'language', 'created_by', 'updated_by'];

    public function contents()
    {
        return $this->hasMany('App\Models\CourseContent');
    }

    public function loadContents()
    {
        $this->load('contents');
    }
}
