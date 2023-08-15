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

/** for side bar menu active **/
/*
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}
*/

/** Auth */
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('home');
    Route::get('/logout', 'logout')->name('logout');
});
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/driver_sendalert/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'driver_sendalert'])->name('driver_sendalert');

Route::group(['middleware'=>'auth'],function()
{
    /** main dashboard */
    Route::controller(statiticsController::class)->group(function () {
        Route::get('/home', 'home')->name('home');
    });
    /** Data Management */
    Route::resource('lines',LinesController::class);
    Route::get('/getfile/{filename}', [App\Http\Controllers\Dashboard\DriversController::class,'download_file'])->name('getfile');

    Route::get('/down_contract_file/{id}',[App\Http\Controllers\Dashboard\DriversController::class, 'down_contract_file'])->name('down.contract_file');

    Route::resource('drivers',DriversController::class);
    Route::get('/driver_trips/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'driver_trips'])->name('driver_trips');
    Route::get('/active_driver/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'active_driver'])->name('active_driver');
    Route::get('/inactive_driver/{id}', [App\Http\Controllers\Dashboard\DriversController::class, 'inactive_driver'])->name('inactive_driver');

    Route::resource('trips',TripsController::class);
    Route::post('/trip_completed/{$id}', [App\Http\Controllers\Dashboard\TripsController::class, 'trip_completed'])->name('trip_completed');

    Route::resource('students',StudentsController::class);
    Route::get('/cancel_trip_student', [App\Http\Controllers\Dashboard\StudentsController::class, 'cancel_trip_student'])->name('cancel_trip_student');
    Route::get('/notifications', [App\Http\Controllers\Dashboard\SettingsController::class, 'notifications'])->name('notifications_admin');
    

     /** settings */
    Route::get('/alerts', [App\Http\Controllers\Dashboard\SettingsController::class, 'alerts'])->name('alerts');
    Route::get('/suggestions', [App\Http\Controllers\Dashboard\SettingsController::class, 'suggestions'])->name('suggestions');
    Route::get('/profile_admin', [App\Http\Controllers\Dashboard\SettingsController::class, 'profile_admin'])->name('profile_admin');
    Route::post('/profile_edit', [App\Http\Controllers\Dashboard\SettingsController::class, 'profile_edit'])->name('profile_edit');
    Route::get('/password_forget', [App\Http\Controllers\Dashboard\SettingsController::class, 'password_forget'])->name('password_forget');
    Route::post('/change_password', [App\Http\Controllers\Dashboard\SettingsController::class, 'inactive_driver'])->name('inactive_driver');


// ----------------------------- forget password ----------------------------//

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('forget-password', 'getEmail')->name('forget-password');
    Route::post('forget-password', 'postEmail')->name('forget-password');
});

// ----------------------------- reset password -----------------------------//

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'getPassword');
    Route::post('reset-password', 'updatePassword');
});
Route::get('/clear', function() {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'All routes cache has just been removed';
});
});



