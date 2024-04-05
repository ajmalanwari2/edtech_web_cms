<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInParent extends Model
{
    use HasFactory;


    use HasFactory;
    // use SoftDeletes;
    public $timestamps = true;

    protected $fillable  = ['student_parent_id', 'student_id', 'created_by'];


    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function studentParentId()
    {
        return $this->belongsTo('App\Models\StudentParent', 'student_parent_id', 'id')->get();
    }
    public function studentId()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }
}
