<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class LibraryAudio extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'subject_id', 'description', 'status', 'created_by', 'updated_by'];
    public $table = 'library_audios';
    public function subjects()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }


    public function library_audio_contents()
    {
        return $this->hasMany(LibraryAudioContent::class);
    }

    public function contents()
    {
        return $this->hasMany('App\Models\LibraryAudioContent');
    }

    public function loadContents()
    {
        $this->load('contents');
    }

}
