<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FaceBookController extends Controller
{
    //
    function redirectTofacebook(){

          return  Socialite::driver('facebook')->redirect();
    }


    function handlefacebookCallback(){

          $SocialiteUser=Socialite::driver('facebook')->user();

          $user=User::where('email',$SocialiteUser->getEmail())->first();

          if ($user) {
             $user->update([
                'facebook_id'=> $SocialiteUser->getId()
             ]);
          }else{
            return redirect()->route('login');
          }

          Auth::login($user);

          $user=Auth::user();

        if ($user->role === 'teacher') {
           return redirect()->intended(route('teacher.dashbord', absolute: false));

        }
        elseif($user->role === 'admin')
        {
           return redirect()->intended(route('admin.dashbord', absolute: false));
        }
        else
        {
          return redirect()->intended(route('dashboard', absolute: false));
        }


    }
}
