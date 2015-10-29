<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function students() {
    	return $this->hasMany('App\SubjectStudent');
    }
}
