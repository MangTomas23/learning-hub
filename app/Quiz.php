<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function questions() {
    	return $this->hasMany('App\Question');
    }

    public function subject() {
    	return $this->belongsTo('App\Subject');
    }

    public function results() {
    	return $this->hasMany('App\Result');
    }

    public function noAttempts() {
        return $this->hasMany('App\Attempt', 'quiz_id');
    }
}
