<?php

namespace App\Http\Controllers;

use App\Models\teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function Symfony\Component\Clock\now;

class AdminController extends Controller
{
    //



    function admindashbord() : View {
        return view('admin.dashbord');
    }



    function adminprofile(Request $request){
         return view('admin.profile', [

         'user' => $request->user(),

         ]);
    }

    function verfiyemail($id){

      $user=User::findOrFail($id);

      $user->update(['email_verified_at'=> now()]);

      return redirect('/login')
       ->with('msg','Email verified. You can login now.')
       ->with('type','success');
    }
}
