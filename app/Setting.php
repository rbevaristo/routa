<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'sched_dayoff', 'dayoff', 'shift', 'user_id','sched_lock'
    ];

    public function user() {
        return $this->belongsTo('App\Manager');
    }
}
