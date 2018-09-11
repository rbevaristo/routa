<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'code', 'verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function verify() {
        return $this->hasOne('App\VerifyUser');
    }

    public function profile() {
        return $this->hasOne('App\CompanyProfile');
    }

    public function managers() {
        return $this->hasMany('App\Manager');
    }

    public function positions() {
        return $this->hasMany('App\Position');
    }

    public function evaluation_results() {
        return $this->hasMany('App\EvaluationResult', 'user_id');
    }

    public function evaluation_files() {
        return $this->hasMany('App\EvaluationFile', 'user_id');
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
