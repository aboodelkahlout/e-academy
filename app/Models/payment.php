<?php

namespace App\Models;

use App\Models\order;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    //
    protected $guarded = [];

    function order(){
        return $this->belongsTo(order::class);
    }
}
