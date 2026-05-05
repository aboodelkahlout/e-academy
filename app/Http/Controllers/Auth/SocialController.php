<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialController
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
       $socialUser = Socialite::driver('google')->user();

    $user = User::where('email', $socialUser->getEmail())->first();


    if ($user) {
        // لو موجود مسبقًا، نحدث بيانات السوشيال
        $user->update([
            'google_id' => $socialUser->getId(),
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

