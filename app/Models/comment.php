<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    //
    protected $fillable = [
        'course_id',
        'user_id',
        'video_id',
        'comment',
    ];


    function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    function course(){
        return $this->belongsTo(course::class, 'course_id');
    }

    function video(){
        return $this->belongsTo(CourseVideo::class, 'video_id');
    }
}
