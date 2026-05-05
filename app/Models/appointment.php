<?php

namespace App\Models;

use App\Models\User;
use App\Models\teacher;
use App\Models\teacher_schedule;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    //
    protected $guarded = [];


    function user(){
        return $this->belongsTo(User::class);
    }


    function teacher(){
        return $this->belongsTo(teacher::class);
    }


    function teacher_schedule(){
        return $this->belongsTo(teacher_schedule::class , 'schedule_id');
    }
}
