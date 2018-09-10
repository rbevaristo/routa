<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'user_id', 'name'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function managers() {
        return $this->hasMany('App\Manager');
    }

    public function employees() {
        return $this->hasMany('App\Employee');
    }
}
