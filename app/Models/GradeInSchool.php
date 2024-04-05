<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeInSchool extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    public $table = 'grades_in_schools';

    protected $fillable  = ['school_id', 'grade_id', 'created_at', 'created_by'];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function gradeId()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id', 'id');
    }
    public function schoolId()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }
    
}
