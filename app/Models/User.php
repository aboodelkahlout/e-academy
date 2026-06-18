<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\order;
use App\Models\course;
use App\Models\teacher;
use App\Models\appointment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory , HasApiTokens , Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cover' ,
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    function teacher(){  // relation with user and teachers table
        return $this->hasOne(teacher::class);
    }


    function appointment(){  //في حال كان طالب له فقط مقابلة واحدة
        return $this->hasOne(appointment::class);
    }

    function order(){  // في حال كان طالب له اكثر من طلب
        return $this->hasMany(order::class);
    }

    function course(){  // if he was a student he had so many courses
        return $this->belongsToMany(course::class);
    }

    function comment(){
        return $this->hasMany(comment::class);
    }

}
