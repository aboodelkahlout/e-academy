<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user=Auth::user();
        if ($user->role== 'admin' ) {
             return view('admin.profile', [
            'user' => $request->user(),
        ]);
        }elseif($user->role == 'teacher'){
           return view('teacher.profile', [
            'user' => $request->user(),
        ]);
        }
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $user=Auth::user();

        if ($user->role === 'teacher') {
        return Redirect::route('teacher.profile')->with('status', 'profile-updated');
        }
        elseif($user->role === 'admin')
        {
           return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
        else
        {
        return Redirect::route('student.profile.edit')->with('status', 'profile-updated');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
