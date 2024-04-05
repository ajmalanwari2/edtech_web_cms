<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_no',
        'gender', 
        'dob',
        'user_id',
        'province_id',
        'district_id',
        'school_id',
        'grade_id',
    ];
    public $timestamps = true;
    public function province()
    {
        return $this->hasOne('App\Models\Province', 'id', 'province_id');
    }

    public function school()
    {
        return $this->hasOne('App\Models\School', 'id', 'school_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function students_in_parents()
    {
        return $this->hasMany('App\Models\StudentInParent', 'student_parent_id', 'id');
    }
}
