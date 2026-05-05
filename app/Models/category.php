<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //

    protected $guarded = [];


    public function courses(){
        return $this->hasMany(course::class);
    }
}
