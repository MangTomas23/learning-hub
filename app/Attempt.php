<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    public function student() {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
