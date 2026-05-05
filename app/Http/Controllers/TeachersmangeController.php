<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeTeachers;
use App\Models\teacher;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\delete;

class TeachersmangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allteachers=User::where('role','teacher')->whereNotNull('email_verified_at')->with('teacher')->latest()->paginate(10);
        return view('admin.index',compact('allteachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.addteacher');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
             'name'             => 'required|min:3',
             'email'            => 'required|email|unique:users,email',
             'password'         => 'required|min:6',
              'cover'            => 'image|mimes:jpg,png,jpeg|max:2048',
             'phone'            => 'required',
             'years_of_experience' => 'required|integer|min:0',
             'bio'              => 'required',
        ]);


        $filename='no-img.png';
        if ($request->hasFile('cover')) {
            $file=$request->file('cover');
            $filename= time().'.'. $file->getClientOriginalExtension();
            $file->move(public_path('cover'),$filename);
        }



       $user = User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'cover'=>$filename,
            'role'=>'teacher'
        ]);



        $id=$user->id;

        teacher::create([
        'user_id'=> $id ,
        'phone'=>$request->phone,
        'years_of_experience'=>$request->years_of_experience,
        'bio'=>$request->bio,
        ]);



        $info = [
            'id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];

        Mail::to($request->email)->send(new WelcomeTeachers($info));

        return back();

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
    public function update(Request $request, string $id)
    {
        //
         $request->validate([
             'name'                => 'required|min:3',
             'email'               => 'required|email|unique:users,email,' . $id,
             'cover'               => 'image|mimes:jpg,png,jpeg|max:2048',
             'phone'               => 'required',
             'years_of_experience' => 'required|integer|min:0',
             'bio'                 => 'required',
        ]);


         $userinfo=user::find($id);

           $filename=$userinfo->cover;

        if ($request->hasFile('cover')) {
            $file=$request->file('cover');
            $filename= time().'.'. $file->getClientOriginalExtension();
            $file->move(public_path('cover'),$filename);
        }




       $userupdated = $userinfo->update([
            'name'=> $request->name,
            'email'=>$request->email,
            'cover'=>$filename
        ]);



        $teacherinfo=teacher::where('user_id' , $id)->firstOrFail();

        $teacherupdated = $teacherinfo->update([
        'phone'=>$request->phone,
        'years_of_experience'=>$request->years_of_experience,
        'bio'=>$request->bio,
        ]);


        return response()->json([
            'id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'cover'=> asset('cover/' . $filename),
            'phone' => $request->phone,
            'bio' => $request->bio,
            'years_of_experience' => $request->years_of_experience,
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $teacher=User::find($id);
        $imgpath=public_path('cover/' . $teacher->cover);
        $teacher->delete();

        if ($teacher->cover !== 'no-img.png') {
            File::delete($imgpath);
        }
        
        return back()->with('msg','deleted succssfuly')->with('type','success');
    }
}
