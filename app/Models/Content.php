<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'subject_lessons';

    protected $fillable  = ['id', 'chapter_id', 'title', 'body', 'file_size', 'type', 'created_by', 'updated_by'];

    public function chapters()
    {
        return $this->belongsTo('App\Models\Chapter', 'chapter_id', 'id');
    }
}
