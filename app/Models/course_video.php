<?php

namespace App\Models;

use App\Models\course;
use Illuminate\Database\Eloquent\Model;

class course_video extends Model
{
    //
    protected $guarded = [];

    function course(){
        return $this->belongsTo(course::class);
    }
}
