<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'status', 'is_center', 'province_id', 'created_by', 'updated_by'];

    public function provinces()
    {
        return $this->belongsTo('App\Models\Province', 'province_id', 'id');
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function contents()
    {
        return $this->hasMany('App\Models\School');
    }

    public function loadContents()
    {
        $this->load('contents');
    }
}
