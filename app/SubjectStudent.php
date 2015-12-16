<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectStudent extends Model
{
    protected $fillable = ['subject_id', 'user_id'];

    public function student() {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function subject() {
    	return $this->belongsTo('App\Subject');
    }
}
