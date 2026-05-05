<?php

namespace App\Models;

use App\Models\appointment;
use App\Models\teacher;
use Illuminate\Database\Eloquent\Model;

class teacher_schedule extends Model
{
    //
    protected $guarded = [];


    function teacher(){
        return $this->belongsTo(teacher::class);
    }


    function appointment(){
        return $this->hasOne(appointment::class);
    }
}
