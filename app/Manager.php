<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email', 'password', 'active', 'is_reset', 'user_id', 'position_id', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function profile() {
        return $this->hasOne('App\Profile', 'man_id');
    }

    public function employees() {
        return $this->hasMany('App\Employee', 'manager_id');
    }

    public function position() {
        return $this->belongsTo('App\Position');
    }

    public function evaluation_results() {
        return $this->hasMany('App\EvaluationResult', 'manager_id');
    }

    public function evaluation_files() {
        return $this->hasMany('App\EvaluationFile', 'manager_id');
    }

    public function setting() {
        return $this->hasOne('App\Setting', 'user_id');
    }

    public function criteria(){
        return $this->hasOne('App\Criteria', 'user_id');
    }

    public function shifts(){
        return $this->hasMany('App\Shift', 'user_id');
    }

    public function required_shifts(){
        return $this->hasMany('App\RequiredShift', 'user_id');
    }

    public function scheduler(){
        return $this->hasOne('App\Scheduler', 'user_id');
    }

    public function employee_schedules(){
        return $this->hasMany('App\EmployeeSchedule', 'user_id');
    }

    public function schedule_files(){
        return $this->hasMany('App\Schedule', 'user_id');
    }

    public function resets() {
        return $this->hasMany('App\EmployeePasswordReset', 'user_id');
    }

    public function user_requests() {
        return $this->hasMany('App\UserRequest', 'user_id');
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
