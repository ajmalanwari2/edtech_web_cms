<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'course_id', 'title', 'body', 'type', 'created_by', 'updated_by'];

    public function courses()
    {
        return $this->belongsTo('App\Models\Course', 'course_id', 'id');
    }
}
