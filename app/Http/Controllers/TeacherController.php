<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\SchedulesRequest;
use App\Http\Requests\TeacherCourseRequest;
use App\Models\appointment;
use App\Models\category;
use App\Models\course_student;
use App\Models\course;
use App\Models\CourseVideo;
use App\Models\teacher;
use App\Models\teacher_schedule;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use function Pest\Laravel\json;

class TeacherController extends Controller
{
    //

    function teacherdashbord(){

        return view('teacher.dashbord');

    }


    function teacherprofile(){

        $user=Auth::user();


        return view('teacher.profile',compact('user'));
    }


    function UpdateImg(Request $request){

      $request->validate([
        'cover' =>'nullable|image|mimes:jpg,png,jpeg|max:2048'
      ]);

      $user=Auth::user();

      $filename='no-img.png';
       if ($request->hasFile('cover')) {
            $file=$request->file('cover');
            $filename= time().'.'. $file->getClientOriginalExtension();
            $file->move(public_path('cover'),$filename);

            if ($user->cover && $user->cover !== 'no-img.png') {
                $img_path=public_path('cover/'. $user->cover);
                File::delete($img_path);
            }
        }




        $user->update(['cover' => $filename]); //عملية التحديث تكون على موديل كامل لانه عبارة عن كيان كامل


        if ($user->role == 'teacher') {
        return Redirect::route('teacher.profile')->with('msg', 'profile-updated')->with('type','success');
        }
        elseif($user->role == 'admin')
        {
        return Redirect::route('admin.profile')->with('msg', 'profile-updated')->with('type','success');
        }
        else
        {
        return Redirect::route('student.profile.edit')->with('msg', 'profile-updated')->with('type','success');
        }

    }


    function teachercourse(){

        $teacher=Auth::user()->teacher;

        $allcourse=$teacher->course;

        return view('teacher.teachercourse',compact('allcourse','teacher'));
    }


    public function destroy(string $id)
    {
        //

        $teacher = Auth::user()->teacher;

        $course=course::where('id', $id)->where('teacher_id' , $teacher->id)->firstOrFail();

        $img_path=public_path('cover/'. $course->course_cover);

         if ($course->course_cover !== 'no-img.png') {
            File::delete($img_path);
        }


        $course->delete();


        return back()->with('msg','deleted successfully')->with('type','success');

    }



     public function create()
    {
        $categories = category::all();
        return view('teacher.addcourse',compact('categories'));
    }


   public function store(TeacherCourseRequest $request)
    {
        //
       $data = $request->validated();

        $filename='no-img.png';
        if ($request->hasFile('course_cover')) {
            $file=$request->file('course_cover');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('cover'),$filename);
            $data['course_cover']=$filename;
            }

        $teacher=Auth::user()->teacher;

        $data['teacher_id']=$teacher->id;

        course::create($data);


        return redirect()->route('teacher.allcourse')->with('msg', 'added successfully')->with('type','success');

    }


    function edit($id){

      $teacher = Auth::user()->teacher;

      $categories=category::all();

      $mycourse=course::where('id',$id)->where('teacher_id' , $teacher->id)->firstOrFail();

     return view('teacher.updatecourse',compact('mycourse','categories'));

    }


    function  update(TeacherCourseRequest  $request , $id){

        $data=$request->validated();

        $teacher=Auth::user()->teacher;

        $course=course::Where('id',$id)->where('teacher_id', $teacher->id)->firstOrFail();


        $filename=$course->course_cover;

        if ($request->hasFile('course_cover')) {
            if ($course->course_cover && $course->course_cover !== 'no-img.png') {
                $img_path=public_path('cover/' . $course->course_cover);
                File::delete($img_path);
            }
            $file=$request->file('course_cover');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('cover'),$filename);
            $data['course_cover']=$filename;
            }

            $course->update($data);

            return redirect()->route('teacher.allcourse')->with('msg','updated successfully')->with('type','success');
    }


    function  getcourseinfo($id){

        $teacher    = Auth::user()->teacher;
        $teacher_id = $teacher->id;
        $course     = course::where('id',$id)->where('teacher_id',$teacher_id)->with('students')->firstOrFail();
        $stu = $course->students;
        $stu_count = $course->students()->count();

     return response()->json([
        'stu_count' => $stu_count,
        'students' => $stu,
     ]);
    }


    function schedules(){
        return view('teacher.addschedules');
    }


    function schedulesstore(SchedulesRequest $request){


         $valid = $request->validated();


         $teacher_id=Auth::user()->teacher->id;

         $valid['teacher_id'] = $teacher_id ;

         teacher_schedule::create($valid);

         return redirect()->route('teacher.schedules.show')->with('msg','success schedule added')->with('type','success');
    }


    function schedulesshow(){

    $teacher_id= Auth::user()->teacher->id;

    $schedules = teacher_schedule::where('teacher_id',$teacher_id)->get();

    return view('teacher.myschedules',compact('schedules'));
    }

    function appointmentshow(){

      $teacher_id =Auth::user()->teacher->id;

      $appointments=appointment::where('teacher_id',$teacher_id)->with('teacher_schedule')->get();

      return view('teacher.appointments',compact('appointments'));
    }

        public function updateField(Request $request)
        {
            $schedule = teacher_schedule::findOrFail($request->id);

            $allowed = ['date', 'start_time', 'end_time'];

            if (!in_array($request->field, $allowed)) {
                abort(403);
            }

            $schedule->update([
                $request->field => $request->value
            ]);

            return response()->json(['success' => true]);
        }

        public function toggleStatus(Request $request)
        {
            $schedule = teacher_schedule::findOrFail($request->id);

            $schedule->update([
                'is_available' => $request->is_available
            ]);

            return response()->json(['success' => true]);
    }

    function deleteschedules($id){

        $schedule = teacher_schedule::findOrFail($id);

        $schedule->delete();

        return response()->json(['success'=>true]);

    }

    function createvideo(Request $request , course $course){

        return view('teacher.addvideo',compact('course'));

    }

    function storevideo(Request $request , course $course){


        $request->validate([
             'title'=>'required|string|max:255',
             'duration'=>'required|integer|min:0',
             'video_path' =>  'required|file|max:200000',
                ]);


        $file = $request->file('video_path');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('video'), $filename);


       $data= CourseVideo::create([
            'course_id' => $course->id,
            'title'=> $request->title,
            'duration' => $request->duration,
            'video_path' => $filename
        ]);

        return redirect()->route('teacher.course.video.create', $course->id)->with('msg', 'Video uploaded successfully')->with('type', 'success');

    }

}

