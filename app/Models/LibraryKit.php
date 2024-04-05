<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class LibraryKit extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'number', 'name', 'description', 'status', 'created_by', 'updated_by'];

    public function subjects()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }


    public function library_kit_contents()
    {
        return $this->hasMany(LibraryKitContent::class);
    }

    public function contents()
    {
        return $this->hasMany('App\Models\LibraryKitContent');
    }

    public function loadContents()
    {
        $this->load('contents');
    }

}
