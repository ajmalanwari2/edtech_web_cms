<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryKitContent extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'title', 'body', 'file_size','library_kit_id','created_by', 'updated_by'];
}
