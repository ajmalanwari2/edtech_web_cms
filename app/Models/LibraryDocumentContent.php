<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryDocumentContent extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'title', 'body','is_main', 'file_size', 'library_document_id','created_by', 'updated_by'];
}
