<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryAudioContent extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'title', 'body','library_audio_id','created_by', 'updated_by'];
}
