<?php

namespace App\Http\Controllers;

use App\Models\appointment;
use App\Models\comment;
use App\Models\course;
use App\Models\CourseStudent;
use App\Models\CourseVideo;
use App\Models\teacher_schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //

    function dashboard(){

        $user_id = Auth()->user()->id;

        $course = CourseStudent::where('student_id', $user_id)->with('course')->get();


        return view('student.dashboard',compact('course'));
    }

    function  teacherschedules(){

      $schedules = teacher_schedule::where('is_available' , 1 )->get();

       return view('student.teacherschedules',compact('schedules'));
    }

    function showfirstvideo($id){

        $firstVideo = CourseVideo::where('course_id', $id)->first();


        $videos= CourseVideo::where('course_id', $id)->get();



        if ($firstVideo) {

        $comments = comment::where('course_id', $id)->where('video_id',$firstVideo->id)->with('user')->get();

        return view('student.firstvideos', compact('firstVideo', 'videos', 'comments'));
        } else {
            return redirect()->back()->with('error', 'No videos found for this course.');
        }
    }


    function nextvideos($id,$course){

        $firstVideo = CourseVideo::find($id);

        $videos= CourseVideo::where('course_id', $course)->get();



        if ($firstVideo) {

            $comments = comment::where('course_id', $course)->where('video_id',$id)->with('user')->get();

            return view('student.nextvideo', compact('firstVideo', 'videos','comments'));

            } else {
            return redirect()->back()->with('error', 'Video not found.');
        }
    }

    function myappointment(){

    $user_id = Auth()->user()->id;

    $appointments=appointment::where('user_id',$user_id)->where('status','accepted')->get();


    return view('student.myappointment',compact('appointments'));
    }


    function storecomment(Request $request, $course, $video)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $user_id = Auth()->user()->id;


       $comment = comment::create([
            'user_id' => $user_id,
            'course_id' => $course,
            'video_id' => $video,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }


}
