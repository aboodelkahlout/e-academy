<?php

namespace App\Models;

use App\Models\course;
use Illuminate\Database\Eloquent\Model;

class cart_item extends Model
{
    //
    protected $guarded = [];


    public function course(){
        return $this->belongsTo(course::class);
    }

        public function user(){
        return $this->belongsTo(user::class);
    }
}
