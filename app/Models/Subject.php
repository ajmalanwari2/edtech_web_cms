<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'status', 'icon', 'created_by', 'updated_by'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }


    public function lessons()
    {
        return $this->hasMany('App\Models\Chapter', 'subject_id', 'id');
    }
}
