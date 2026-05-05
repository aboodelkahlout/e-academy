<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\course;
use App\Models\teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class mangecourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $allcourse=course::with('teacher')->paginate(10);
        $allteacher=teacher::all();
        return view('admin.courseindex',compact('allcourse','allteacher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allteacher = teacher::with('user')->get();

        return view('admin.addcourse',compact('allteacher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
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


        course::create($data);

        return redirect()->route('admin.course.index')->with('msg', 'added successfully')->with('type','success');



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, string $id)
    {
        //
        $data=$request->validated();

        $course=course::find($id);

        $filename=$course->course_cover;

        if ($request->hasFile('course_cover')) {
            $file=$request->file('course_cover');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('cover'),$filename);
            $data['course_cover']=$filename;
            }


            $course->update($data);

            $teacher_id=teacher::find($course->teacher_id);
            $teacher_name=$teacher_id->user->name;

            return response()->json([
                    'id'=>$id,
                    'teacher_id'=> $teacher_name,
                    'title' => $course->title,
                    'description' => $course->description,
                    'specialization' => $course->specialization,
                    'duration' => $course->duration,
                    'price' => $course->price,
                    'course_cover' => asset('cover/' . $filename),
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $course=course::find($id);
        $img_path=public_path('cover/'. $course->course_cover);

         if ($course->course_cover !== 'no-img.png') {
            File::delete($img_path);
        }


        $course->delete();


        return back()->with('msg','deleted successfully')->with('type','success');

    }
}
