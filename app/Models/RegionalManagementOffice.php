<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalManagementOffice extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'abbreviation', 'status','contact_name', 'phone', 'email','gps', 'created_by', 'updated_by'];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }


    public function contents()
    {
        return $this->hasMany('App\Models\Province');
    }

    public function loadContents()
    {
        $this->load('contents');
    }
}
