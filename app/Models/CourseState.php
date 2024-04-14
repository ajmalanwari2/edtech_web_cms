<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseState extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'course_id', 'user_id', 'state', 'created_by', 'updated_by'];

}
