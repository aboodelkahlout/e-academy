<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
    //
    protected $guarded = [];

    function order(){

     return  $this->belongsTo(order::class);
    }

    function course(){

     return  $this->belongsTo(course::class);

     }
}
