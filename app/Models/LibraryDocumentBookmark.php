<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryDocumentBookmark extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'library_document_id', 'user_id', 'state'];

}
