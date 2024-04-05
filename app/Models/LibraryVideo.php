<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class LibraryVideo extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'subject_id', 'description', 'status', 'created_by', 'updated_by'];

    public function subjects()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }


    public function library_video_contents()
    {
        return $this->hasMany(LibraryVideoContent::class);
    }

    public function contents()
    {
        return $this->hasMany('App\Models\LibraryVideoContent');
    }

    public function loadContents()
    {
        $this->load('contents');
    }

}
