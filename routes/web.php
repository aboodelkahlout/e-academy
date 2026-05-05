<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\FaceBookController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\categorymangeController;
use App\Http\Controllers\mangecourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeachersmangeController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/',[SiteController::class , 'welcome'])->name('welcome');

Route::prefix('site')->name('site.')->group(function(){
    Route::get('courses',[SiteController::class,'courses'])->name('courses');
    Route::get('ourteachers',[SiteController::class,'ourteachers'])->name('ourteachers');
    Route::get('teacherdetails/{id}',[SiteController::class,'teacherdetails'])->name('teacherdetails');
    Route::get('course/details/{id}',[SiteController::class , 'coursedetails'])->name('coursedetails');
    Route::post('course/{id}/addcart/',[SiteController::class ,'addtocart'])->name('addtocart')->middleware('auth');
    Route::get('course/showcart',[SiteController::class , 'showcart'])->name('showcart');
    Route::get('checkout',[SiteController::class,'checkout'])->name('checkout');
    Route::get('payment',[SiteController::class,'payment'])->name('payment');
    Route::post('payment',[SiteController::class,'paymentaction'])->name('paymentaction');
    Route::get('pay/action/',[SiteController::class , 'payaction'])->name('payaction');


});

Route::get('verfiy/youremail/{id}',[AdminController::class,'verfiyemail'])->name('verfiy.email');


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function() {

    // Route::get('/student/dashboard', function () {
    //     return view('student.dashboard');
    // })->middleware(['auth', 'verified','CheckRole:student'])->name('dashboard');


    Route::prefix('student')->name('student.')->middleware(['auth', 'verified','CheckRole:student'])->group(function(){
        Route::get('/dashboard',[StudentController::class,'dashboard'])->name('dashboard');
        Route::get('teacher/schedules',[StudentController::class,'teacherschedules'])->name('schedules');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });



    Route::middleware('auth')->group(function () {

});



    Route::prefix('admin')->name('admin.')->middleware(['auth','CheckRole:admin'])->group(function() {
        Route::get('dashbord',[AdminController::class,'admindashbord'])->name('dashbord');
        Route::get('profile',[AdminController::class, 'adminprofile'])->name('profile');
        Route::resource('teacher',TeachersmangeController::class);
        Route::resource('course',mangecourseController::class);
        Route::resource('category',categorymangeController::class);
        });


    Route::put('profile/update',[TeacherController::class,'UpdateImg'])->name('update.img')->middleware(['auth','verified']);


 Route::prefix('teacher')->name('teacher.')->middleware(['auth','CheckRole:teacher','verified'])->group(function() {
        Route::get('dashbord',[TeacherController::class, 'teacherdashbord'])->name('dashbord');
        Route::get('course',[TeacherController::class, 'teachercourse'])->name('allcourse');
        Route::get('profile',[TeacherController::class, 'teacherprofile'])->name('profile');
        Route::delete('course/{id}',[TeacherController::class, 'destroy'])->name('course.destroy');
        Route::put('course/{id}',[TeacherController::class, 'update'])->name('course.update');
        Route::get('course/create',[TeacherController::class, 'create'])->name('course.create');
        Route::post('course',[TeacherController::class, 'store'])->name('course.store');
        Route::get('course/{id}',[TeacherController::class, 'edit'])->name('course.edit');
        Route::put('course/{id}',[TeacherController::class, 'update'])->name('course.update');
        Route::get('course/info/{id}',[TeacherController::class,'getcourseinfo'])->name('course.info');
        Route::get('schedules',[TeacherController::class,'schedules'])->name('schedules');
        Route::post('schedules/store',[TeacherController::class,'schedulesstore'])->name('schedules.store');
        Route::get('schedules/show',[TeacherController::class,'schedulesshow'])->name('schedules.show');
        Route::get('appointment',[TeacherController::class,'appointmentshow'])->name('appointment.show');
        Route::post('schedules/update', [TeacherController::class, 'updateField']);
        Route::post('schedules/toggle-status', [TeacherController::class, 'toggleStatus']);
        Route::delete('schedules/delete/{id}',[TeacherController::class, 'deleteschedules'])->name('schedules.delete');
 });




});




Route::get('/auth/google', [SocialController::class, 'redirectToGoogle'])->name('social.login');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback']);



Route::get('/auth/facebook', [FaceBookController::class, 'redirectTofacebook'])->name('facebook.login');
Route::get('/auth/facebook/callback', [FaceBookController::class, 'handlefacebookCallback']);









require __DIR__.'/auth.php';
