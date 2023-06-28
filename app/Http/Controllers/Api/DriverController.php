<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\trip;
use App\Models\student;
use App\Models\User;
use App\Http\Controllers\BaseController;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\TripCancel_admin;
use App\Notifications\TripCancel_students;

use App\Notifications\status_TripStudents;
use App\Notifications\status_TripAdmin;

class DriverController extends BaseController
{ 
    public function show_my_trips()
    {
        $driver=auth()->guard('driver-api')->user()->id;
        $trips=trip::where('driver_id',$driver)->get();
        return $this->sendResponse($trips, 'Driver Trips');
    }

    public function cancel_trip($tripId)
    {
        $trip=trip::where('id',$tripId)->update([
            'status'=>'تم الالغاء'
        ]);
        /*
        $driver=driver::where('id',$trip->id)->update([
            'alert_count'=>$driver->alert_count++,]);
        */

        //send notify to admin  for know trip cancelled
        $trip=trip::where('id',$tripId)->first();
        $admin=User::where('id','1')->first();
        $driver=driver::where('id',$trip->driver_id)->first();
       
        $admin->notify(new TripCancel_admin($trip,$driver));

        $students = student::whereHas('trips', function ($query) use ($tripId) {
            $query->where('trip_id', $tripId);
        })->get();
        //send notification all users
        $trip = trip::find($tripId); 
        $trip->students()->detach($students);
        \Notification::send($students,new TripCancel_students($trip));
    }
    public function show_details_for_current_trip($tripId)
    { 
        $trip=trip::where('id',$tripId)->with([
            'driver',
            'line',
            'students',
        ])->first();
        return $this->sendResponse($trip,'current_trip');
    }
    public function check_box_trip($tripId,Request $request)
    {
        $trip=trip::where('id',$tripId)->update([
            'status'=>$request->status,
        ]);

        //send notify admin update trip status
        $trip=trip::where('id',$tripId)->first();
        $admin=User::where('id','1')->first();
        $driver=driver::where('id',$trip->driver_id)->first();
        $admin->notify(new status_TripAdmin($trip,$driver));
        //send notify students in this trip 
        $students = student::whereHas('trips', function ($query) use ($tripId) {
            $query->where('trip_id', $tripId);
        })->get();
        \Notification::send($students,new status_TripStudents($trip));
        return $this->sendResponse($trip,'current_trip');
    }
    public function show_profile()
    {
        $driver=driver::where('id',Auth::guard('driver-api')->id())->first();
        return $this->sendResponse($driver, 'profile');
    }
    public function browse_map()
    {}
    public function filter_search_trips(Request $request)
    {
        $st_date=$request->st_date;
        $en_date=$request->en_date;
        $trips=trip::where('driver_id',Auth::guard('driver-api')->id())->betweenDates($st_date, $en_date)->with([
            'driver',
            'line',
            'students',
        ])->get();
        return $this->sendResponse($trips, 'results_search_trips');
    }
    public function browse_notifications()
    {
        $driver=driver::where('id',Auth::guard('driver-api')->id())->first();
        $notification=$driver->unreadNotifications;
   
          return $this->sendResponse($notification,'Driver Notifications');
    }
    public function check_box_student($trip_id,$student_id,Request $request)
    {
        $student = student::find($student_id);  
        $student->trips()->updateExistingPivot($trip_id,
         ['status' => $request->status, ]);
        return $this->sendResponse($student,'Update status as'.$request->status);
    }
}
