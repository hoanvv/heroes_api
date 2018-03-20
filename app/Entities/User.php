<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const BLOCKED_USER = 1;
    const UNBLOCKED_USER = 0;

    const DEFAULT_RATING = 5.0;

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

    // Methods for getting status
    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isBlocked()
    {
        return $this->blocked == User::BLOCKED_USER;
    }

    // Relationships
    public function shipper()
    {
        return $this->hasOne('App\Entities\Shipper');
    }

    public function packageOwner()
    {
        return $this->hasOne('App\Entities\PackageOwner');
    }

    public function role()
    {
        return $this->belongsTo('App\Entities\Role');
    }

    public function requestShips()
    {
        return $this->hasMany('App\Entities\RequestShip');
    }

    public function requestTrackings()
    {
        return $this->hasMany('App\Entities\RequestTracking');
    }

    // Utility method
    public static function generateVerificationCode()
    {
        return str_random(40);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
