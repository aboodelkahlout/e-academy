<?php

namespace App\Models;

use App\Models\User;
use App\Models\course;
use App\Models\appointment;
use App\Models\teacher_schedule;
use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    //
    protected $guarded = [];

    function user(){
         return $this->belongsTo(User::class);
    }


    function teacher_schedule(){
        return $this->hasMany(teacher_schedule::class);
    }


    function appointment(){
        return $this->hasMany(appointment::class);
    }


    function course() {
        return $this->hasMany(course::class);
    }
}
