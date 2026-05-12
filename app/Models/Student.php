<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'students';
    protected $fillable = [
        'phone_no',
        'gender', 
        'dob',
        'user_id',
        'province_id',
        'district_id',
        'school_id',
        'grade_id',
        'language',
    ];
    public $timestamps = true;

    public function province()
    {
        return $this->hasOne('App\Models\Province', 'id', 'province_id');
    }

    public function district()
    {
        return $this->hasOne('App\Models\District', 'id', 'district_id');
    }

    public function school()
    {
        return $this->hasOne('App\Models\School', 'id', 'school_id');
    }

    public function grade()
    {
        return $this->hasOne('App\Models\Grade', 'id', 'grade_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

  
}
