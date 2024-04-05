<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'status', 'regional_management_office_id', 'created_by', 'updated_by'];

    public function regional_management_offices()
    {
        return $this->belongsTo('App\Models\RegionalManagementOffice', 'regional_management_office_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }


    public function contents()
    {
        return $this->hasMany('App\Models\District');
    }

    public function loadContents()
    {
        $this->load('contents');
    }
}
