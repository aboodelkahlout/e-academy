<?php

namespace App\Models;

use App\Models\course;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    //
    protected $fillable = [
        'course_id',
        'title',
        'duration',
        'video_path',
    ];


    public function course(){
        return $this->belongsTo(course::class);
    }

}
