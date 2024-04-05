<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'status', 'language', 'created_by', 'updated_by'];

    public function subjects_in_grades()
    {
        return $this->hasMany('App\Models\SubjectInGrade', 'grade_id', 'id');
    }
}
