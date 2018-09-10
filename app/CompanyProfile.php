<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'avatar', 'contact', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function address() {
        return $this->hasOne('App\Address', 'company_id');
    }
}
