<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeetingList extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'user_id', 'state', 'topic', 'start_at', 'duration', 'meeting_password', 'meeting_url', 'created_by', 'created_at', 'updated_by'];


    
}
