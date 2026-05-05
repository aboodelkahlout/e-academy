<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\course;
use Illuminate\Http\Request;

class coursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return course::all();
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


        $created = course::create($data);


        return response()->json([

            "status" => true,
            "msg"  => 'created successfully',
            "data"=> $created,

            ] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
