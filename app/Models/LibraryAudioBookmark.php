<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryAudioBookmark extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'library_audio_id', 'user_id', 'state'];

}
