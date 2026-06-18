<?php

namespace App\Models;

use App\Models\course;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{

    protected $table = 'course_student';


    protected $guarded = [];


    public function course()
    {
        return $this->belongsTo(course::class, 'course_id', 'id');
    }
}
