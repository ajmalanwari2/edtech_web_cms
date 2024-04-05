<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryKitBookmark extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'library_kit_id', 'user_id', 'state'];

}
