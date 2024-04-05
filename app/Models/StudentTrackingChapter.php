<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTrackingChapter extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'student_id', 'chapter_id','chapter_start_date', 'chapter_end_date'];
}
