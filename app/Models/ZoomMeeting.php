<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable  = ['id', 'user_id', 'meeting_id', 'topic', 'start_at','duration', 'password', 'start_url', 'join_url', 'created_by', 'updated_by'];
}
