<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable  = ['id', 'number', 'name', 'url', 'status','icon', 'language', 'created_by', 'updated_by'];
}
