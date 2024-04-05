<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreationRequest extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = [
        'id', 'identity_number', 'first_name', 'last_name', 'father_name', 'gender', 'dob', 'email', 'phone_no',
        'role', 'province_id', 'district_id', 'school_id', 'grade_id', 'student_ids', 'password','language', 'created_by', 'updated_by'
    ];

    public function province()
    {
        return $this->hasOne('App\Models\Province', 'id', 'province_id');
    }

    public function school()
    {
        return $this->hasOne('App\Models\School', 'id', 'school_id');
    }

    public function district()
    {
        return $this->hasOne('App\Models\District', 'id', 'district_id');
    }

    public function grade()
    {
        return $this->hasOne('App\Models\Grade', 'id', 'grade_id');
    }
}
