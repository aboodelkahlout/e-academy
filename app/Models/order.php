<?php

namespace App\Models;

use App\Models\User;
use App\Models\order_item;
use App\Models\payment;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //

    protected $guarded = [];

    function user(){

        return $this->belongsTo(User::class);
    }

    function order_item(){
        return $this->hasMany(order_item::class);
    }


    public function payment() {
    return $this->hasMany(Payment::class);
    }


    


}
