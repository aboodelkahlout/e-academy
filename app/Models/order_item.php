<?php

namespace App\Models;

use App\Models\order;
use App\Models\course;
use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    //
    protected $guarded = [];

    function order(){
        return $this->belongsTo(order::class);
    }

    function course(){
        return $this->belongsTo(course::class);
    }


}
