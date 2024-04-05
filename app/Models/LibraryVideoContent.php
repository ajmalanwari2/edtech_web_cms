<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryVideoContent extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'title', 'body','library_video_id','created_by', 'updated_by'];
}
