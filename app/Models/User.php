<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'identity_number',
        'email',
        'password',
        'last_seen',
        'sync_datetime',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function student()
    {
        return $this->hasOne('App\Models\Student', 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->hasOne('App\Models\Teacher', 'user_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\StudentParent', 'user_id', 'id');
    }

    public function feedback()
    {
        return $this->hasMany('App\Models\Feedback', 'user_id', 'id');
    }
}
