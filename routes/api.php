<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\coursesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



    Route::post('login' ,[AuthController::class ,'login']);



    Route::prefix('v1')->middleware('auth:sanctum')->group(function(){

    Route::apiResource('/courses',coursesController::class);

    });


