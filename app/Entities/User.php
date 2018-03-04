<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const BLOCKED_USER = 1;
    const UNBLOCKED_USER = 0;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role_id',
        'authentication_token',
        'verified',
        'verification_token',
        'blocked'
    ];

    protected $hidden = [
        'password', 'remember_token','verification_token','authentication_token',
    ];

    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isBlocked()
    {
        return $this->blocked == User::BLOCKED_USER;
    }

}
