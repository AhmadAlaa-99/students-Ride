<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AlertsController;
use App\Http\Controllers\Dashboard\DriversController;
use App\Http\Controllers\Dashboard\LinesController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\statiticsController;
use App\Http\Controllers\Dashboard\StudentsController;
use App\Http\Controllers\Dashboard\TripsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('home');
     Route::get('/logout', 'logout')->name('logout');
});
Auth::routes();
Route::get('/', function () 
{
    return view('auth.login');
});
Route::group(['middleware'=>'auth'],function()
{
    /** main dashboard */
    Route::controller(statiticsController::class)->group(function () {
    Route::get('/home', 'home')->name('home');
    });
    /**  Drivers Management*/
    Route::resource('drivers',DriversController::class);
    Route::get('/delete_driver/{id}', [App\Http\Controllers\Dashboard\DriversController::class,'delete_driver'])->name('delete_driver');
    Route::get('/getfile/{filename}', [App\Http\Controllers\Dashboard\DriversController::class,'download_file'])->name('getfile');
    Route::get('/down_contract_file/{id}',[App\Http\Controllers\Dashboard\DriversController::class, 'down_contract_file'])->name('down_contract_file');
    Route::get('/drivers_index_unactive', [App\Http\Controllers\Dashboard\DriversController::class, 'drivers_index_unactive'])->name('drivers_index_unactive');
    Route::get('/driver_trips/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'driver_trips'])->name('driver_trips');
    Route::get('/active_driver/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'active_driver'])->name('active_driver');
    Route::get('/inactive_driver/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'inactive_driver'])->name('inactive_driver');
    Route::get('/receipts_done/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'receipts_done'])->name('receipts_done');
    Route::get('/driver_sendalert/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'driver_sendalert'])->name('driver_sendalert');

    /** Lines Management */
    Route::resource('lines',LinesController::class);
    Route::get('/delete_line/{id}', [App\Http\Controllers\Dashboard\LinesController::class,'delete_line'])->name('delete_line');
    
     //** Trips Management */
     Route::resource('trips',TripsController::class);
     Route::get('/trips_finite', [App\Http\Controllers\Dashboard\TripsController::class, 'trips_finite'])->name('trips_finite');
     Route::get('/trips_current', [App\Http\Controllers\Dashboard\TripsController::class, 'trips_current'])->name('trips_current');
     Route::get('/trips_progress', [App\Http\Controllers\Dashboard\TripsController::class, 'trips_progress'])->name('trips_progress');
     Route::get('/trips_canelled', [App\Http\Controllers\Dashboard\TripsController::class, 'trips_canelled'])->name('trips_canelled');
     Route::get('/trips_delete/{id}', [App\Http\Controllers\Dashboard\TripsController::class, 'trips_delete'])->name('trips_delete');
     Route::get('/trips_reviews/{id}', [App\Http\Controllers\Dashboard\TripsController::class, 'trips_reviews'])->name('trips_reviews');
     Route::post('/trip_completed/{$id}', [App\Http\Controllers\Dashboard\TripsController::class, 'trip_completed'])->name('trip_completed');


    //** Students Management */
    Route::resource('students',StudentsController::class);
    Route::get('/cancel_trip_student', [App\Http\Controllers\Dashboard\StudentsController::class, 'cancel_trip_student'])->name('cancel_trip_student');

    /** Users - Roles Management */
    Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
    });

     /** settings */
     Route::get('/notifications', [App\Http\Controllers\Dashboard\SettingsController::class, 'notifications'])->name('notifications_admin');
     Route::get('/mark_As_read/{id}', [App\Http\Controllers\Dashboard\SettingsController::class, 'mark_As_read'])->name('mark_As_read');
     Route::get('/mark_all_read', [App\Http\Controllers\Dashboard\SettingsController::class, 'mark_all_read'])->name('mark_all_read');

     
     
     Route::get('/alerts', [App\Http\Controllers\Dashboard\SettingsController::class, 'alerts'])->name('alerts');
     Route::get('/suggestions', [App\Http\Controllers\Dashboard\SettingsController::class, 'suggestions'])->name('suggestions');
     Route::get('/profile_admin', [App\Http\Controllers\Dashboard\SettingsController::class, 'profile_admin'])->name('profile_admin');
     Route::post('/profile_edit', [App\Http\Controllers\Dashboard\SettingsController::class, 'profile_edit'])->name('profile_edit');
     Route::get('/password_forget', [App\Http\Controllers\Dashboard\SettingsController::class, 'password_forget'])->name('password_forget');
     Route::post('/change_password', [App\Http\Controllers\Dashboard\SettingsController::class, 'change_password'])->name('change_password');
    });

// ----------------------------- reset password -----------------------------//
Route::controller(ForgotPasswordController::class)->group(function () {
    
    Route::get('getEmail', 'getEmail')->name('getEmail');
    Route::post('forget-password', 'postEmail')->name('post_email');
    Route::post('confirm_code', 'confirm_code')->name('confirm_code');
    Route::post('update_password', 'update_password')->name('update_password');
    });


    Route::get('/clear', function() {
	$exitCode = Artisan::call('cache:clear');
	//$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'All routes cache has just been removed';
    });



