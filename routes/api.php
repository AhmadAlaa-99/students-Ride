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
Route::post('activate',[StudentController::class,'ActivateEmail']);
Route::post('fcm_token_store',[Auth_ApiController::class,'fcm_token_store'])->name('fcm_token_store');
Route::get('/down_contract_file/{id}',[App\Http\Controllers\Dashboard\DriversController::class, 'down_contract_file'])->name('down.contract_file');
/*--------------------------------forgotpassword : just student------------------------*/
Route::post('forgotpasswordCreate', [Auth_ApiController::class, 'forgotPasswordCreate']);//notify email 
Route::post('forgotpassword', [Auth_ApiController::class, 'forgotPasswordToken']);  //request code
Route::post('update_password', [Auth_ApiController::class, 'update_password']);  //update password
/*--------------------------------Driver------------------------*/
Route::post('login_driver',[Auth_ApiController::class,'login_driver'])->name('login_driver');
Route::group(["middleware"=>['auth:driver-api']],function()
{
  
Route::get('show_my_finite_trips',[DriverController::class,'show_my_finite_trips'])->name('show_my_finite_trips');
Route::get('show_my_current_trips',[DriverController::class,'show_my_current_trips'])->name('show_my_current_trips');
Route::get('show_my_next_trips',[DriverController::class,'show_my_next_trips'])->name('show_my_next_trips');
Route::get('show_details_for_current_trip/{id}',[DriverController::class,'show_details_for_current_trip'])->name('show_details_for_current_trip');
Route::post('filter_search_trips',[DriverController::class,'filter_search_trips'])->name('filter_search_trips');
Route::post('start_trip/{id}',[DriverController::class,'start_trip'])->name('start_trip');
Route::post('end_trip/{id}',[DriverController::class,'end_trip'])->name('end_trip');
//Route::post('check_box_student/{trip_id}/{student_id}',[DriverController::class,'check_box_student'])->name('check_box_student');
Route::post('cancel_trip/{id}',[DriverController::class,'cancel_trip'])->name('cancel_trip');
Route::get('show_profile',[DriverController::class,'show_profile'])->name('show_profile');
Route::get('browse_notifications',[DriverController::class,'browse_notifications'])->name('browse_notifications');
});
/*--------------------------------Student------------------------*/
Route::prefix('student/')->group(function ()
{
        Route::post('login_student',[Auth_ApiController::class,'login_student'])->name('login_student');
        //active email   - soon
        //change_password  - soon
        Route::post('Create_Profile',[StudentController::class,'Create_Profile'])->name('Create_Profile');
     Route::group(["middleware"=>['auth:api']],function(){ //, 
        Route::get('Delete_Profile',[StudentController::class,'Delete_Profile'])->name('Delete_Profile'); //alert_count > 5
        Route::get('Show_Profile',[StudentController::class,'Show_Profile'])->name('Show_Profile');
        Route::post('Edit_Profile',[StudentController::class,'Edit_Profile'])->name('Edit_Profile');
        Route::get('Browse_my_Trips',[StudentController::class,'Browse_my_Trips'])->name('Browse_my_Trips');
        Route::get('end_start_lines',[StudentController::class,'end_start_lines']);
        Route::post('information_of_trip',[StudentController::class,'information_of_trip']);
        Route::post('choose_The_Information_trip/{id}',[StudentController::class,'choose_The_Information_trip']);
        Route::get('Cancel_Trip/{id}',[StudentController::class,'Cancel_Trip']);
        Route::get('show_my_current_trips',[StudentController::class,'show_my_current_trips']);
        Route::get('show_details_for_trip/{id}',[StudentController::class,'show_details_for_trip']);
        Route::get('browse_Notification',[StudentController::class,'browse_Notification']);
        Route::post('Send_Suggestion/{trip_id}',[StudentController::class,'Send_Suggestion']);
        Route::get('logout',[Auth_ApiController::class,'logout'])->name('logout_student');
  });
  });
/*--------------------------------Alghorithm------------------------*/
Route::post('Trips_Algorithm',[StudentController::class,'Trips_Algorithm'])->name('Trips_Algorithm');
Route::get('All_inforamtion_of_trip/{id}',[StudentController::class,'All_inforamtion_of_trip'])->name('All_inforamtion_of_trip');







