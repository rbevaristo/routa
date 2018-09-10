<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationFile extends Model
{
    protected $fillable = [
        'filename', 'emp_id', 'manager_id', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function manager(){
        return $this->belongsTo('App\Manager');
    }

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
