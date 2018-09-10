<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'avatar', 'gender', 'birthdate', 'contact', 'man_id', 'emp_id'
    ];

    public function manager() {
        return $this->belongsTo('App\Manager');
    }

    public function employee() {
        return $this->belongsTo('App\Employee');
    }

    public function address() {
        return $this->hasOne('App\Address', 'profile_id');
    }
}
