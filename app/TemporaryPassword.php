<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryPassword extends Model
{
    public function user() {
    	return $this->belongsTo('App/User');
    }
}
