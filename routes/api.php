<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth_ApiController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\StudentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*--------------------------------Driver------------------------*/
Route::post('login_driver',[Auth_ApiController::class,'login_driver'])->name('login_driver');
Route::get('show_my_trips',[DriverController::class,'show_my_trips'])->name('show_my_trips');
Route::post('cancel_trip/{id}',[DriverController::class,'cancel_trip'])->name('cancel_trip');
Route::get('show_details_for_current_trip/{id}',[DriverController::class,'show_details_for_current_trip'])->name('show_details_for_current_trip');
Route::post('check_box_trip/{id}',[DriverController::class,'check_box_trip'])->name('check_box_trip');
Route::post('check_box_student/{trip_id}/{student_id}',[DriverController::class,'check_box_student'])->name('check_box_student');
Route::get('show_profile',[DriverController::class,'show_profile'])->name('show_profile');
Route::post('filter_search_trips',[DriverController::class,'filter_search_trips'])->name('filter_search_trips');
Route::get('browse_notifications',[DriverController::class,'browse_notifications'])->name('browse_notifications');
/*--------------------------------Student------------------------*/


Route::prefix('student/')->group(function (){
    Route::post('login_student',[Auth_ApiController::class,'login_student'])->name('login_student');
    Route::post('Create_Profile',[StudentController::class,'Create_Profile'])->name('Create_Profile');

    Route::group(["middleware"=>['auth:student-api']],function(){
    
        Route::get('Delete_Profile',[StudentController::class,'Delete_Profile'])->name('Delete_Profile');
        Route::get('Show_Profile',[StudentController::class,'Show_Profile'])->name('Show_Profile');
        Route::post('Edit_Profile',[StudentController::class,'Edit_Profile'])->name('Edit_Profile');
        Route::get('Browse_my_Trips',[StudentController::class,'Browse_my_Trips'])->name('Browse_my_Trips');
        Route::get('logout',[Auth_ApiController::class,'logout'])->name('logout');
    });
    });




