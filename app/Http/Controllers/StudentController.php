<?php

namespace App\Http\Controllers;

use App\Models\teacher_schedule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //

    function dashboard(){
        return view('student.dashboard');
    }

    function  teacherschedules(){

      $schedules = teacher_schedule::where('is_available' , 1 )->get();

       return view('student.teacherschedules',compact('schedules'));
    }
    
}
