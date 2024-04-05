<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'regional_management_office_id', 'province_id', 'district_id', 'status', 'created_by', 'updated_by'];

    public function districts()
    {
        return $this->belongsTo('App\Models\District', 'district_id', 'id');
    }
    public function provinces()
    {
        return $this->belongsTo('App\Models\Province', 'province_id', 'id');
    }
    public function regional_management_offices()
    {
        return $this->belongsTo('App\Models\RegionalManagementOffice', 'regional_management_office_id', 'id');
    }
    public function grades_in_schools()
    {
        return $this->hasMany('App\Models\GradeInSchool', 'school_id', 'id');
    }
}
