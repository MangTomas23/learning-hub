<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectStudent extends Model
{
    protected $fillable = ['subject_id', 'user_id'];
}
