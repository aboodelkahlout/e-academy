<?php

namespace App\Models;

use App\Models\category;
use App\Models\course_video;
use App\Models\order_item;
use App\Models\teacher;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    //
    protected $guarded = [];


    function teacher(){
        return $this->belongsTo(teacher::class);
    }



    public function students(){
      return $this->belongsToMany(User::class, 'course_student' , 'course_id' , 'student_id');
    }


    public function orderItems() {
    return $this->hasMany(order_item::class);
}



public function category(){
    return $this->belongsTo(category::class);
}


public function order_item(){
    return $this->hasMany(order_item::class);
}


public function videos()
{
    return $this->hasMany(CourseVideo::class);
}





}
