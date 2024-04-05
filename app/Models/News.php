<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'news';
    protected $fillable  = ['id', 'number', 'title', 'description', 'status','is_emailed', 'photo', 'language', 'created_by', 'updated_by'];
}
