<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadNotice extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable  = ['id', 'notice_id', 'user_id', 'notice_read_datetime', 'created_by', 'updated_by'];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }


    public function contents()
    {
        return $this->hasMany('App\Models\Province');
    }

    public function loadContents()
    {
        $this->load('contents');
    }
}
