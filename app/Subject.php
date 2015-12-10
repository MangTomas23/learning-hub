<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function students() {
    	return $this->hasMany('App\SubjectStudent');
    }

    public function teacher() {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function quizzes() {
    	return $this->hasMany('App\Quiz');
    }
}
