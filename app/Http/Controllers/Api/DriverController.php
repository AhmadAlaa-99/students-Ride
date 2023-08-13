<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use Illuminate\Support\Facades\Json;
use App\Models\trip;
use App\Models\student_trip;
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

    public function show_my_current_trips()
    {
        $driver=auth()->guard('driver-api')->user()->id;
        $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
                ->where('trips.status', '=','حالية')
                ->get();
          return response()->json([
            'status'=>true,
            'data'=>$info
    ]);  

    }
    public function show_my_finite_trips()
    {
       

        $driver=auth()->guard('driver-api')->user()->id;
        $trips = trip::join('lines', 'trips.line_id', '=', 'lines.id')
        ->where([
            'driver_id'=>$driver,
            'status'=>'منتهية',
            ])
        ->get();
        $totalPrice = $trips->sum(function ($trip) {
            return (float) $trip->price_final;
        });
  return response()->json([
    'data'=>$trips,
    'totalPrice'=>$totalPrice,
]);  
      

      
    }
    public function show_my_next_trips()
    {
        $driver=auth()->guard('driver-api')->user()->id;
        $trips=trip::join('lines', 'trips.line_id', '=', 'lines.id')->where([
            'driver_id'=>$driver,
            'status'=>'قادمة',
            ])->get();
            return response()->json([
                'status'=>true,
                'data'=>$trips,
               
            ]);  
    }
    public function start_trip($tripId,Request $request)
    {
        $trip=trip::where('id',$tripId)->update([
            'status'=>'قيد التقدم',
        ]);

        /*
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
        */
        return $this->sendResponse($trip,'current_trip');
    }

    public function end_trip($tripId,Request $request)
    {
      
        $check_box = json_encode($request->input('check_box', []));
        //$check_box = $request->input('check_box', []);
        //return [true,false,truse,false];
        $students=student_trip::where('trip_id',$tripId)->get();
          foreach ($students as $index => $student) {
            $status = boolval($check_box[$index]);
                $student->update([
                    'status'=>$status,
                ]);       
    }
    $num_stu_final=student_trip::where(
        [
            'trip_id'=>$tripId,
            'status'=>'1',
        ])->count();
        $trip=trip::where('id',$tripId)->first();
           $trip->update([
        'status'=>'منتهية',
        'num_stu_final'=>$num_stu_final,
        'price_final'=>$num_stu_final*$trip->line->price,
    ]);

/*
        $student = student::find($student_id);  
        $student->trips()->updateExistingPivot($trip_id,
         ['status' => $request->status, ]);
        return $this->sendResponse($student,'Update status as'.$request->status);
   [false,true,true,true]

        /*
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
        */
    
        return $this->sendResponse($trip,'current_trip');
      
    }
    public function show_details_for_current_trip($tripId)
    { 
        $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
        ->where('trips.id', '=',$tripId)
        ->with([
            'driver',
            'students',
        ])->first();
    
  return response()->json([
    'data'=>$info
]);    
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
         
        $trips=trip::join('lines', 'trips.line_id', '=', 'lines.id')->where(
            ['driver_id'=>Auth::guard('driver-api')->id(),
            'status'=>'منتهية',
            ])->betweenDates($st_date, $en_date)->get();
        $totalPrice = $trips->sum(function ($trip) {
            return (float) $trip->price_final;
        });


         return response()->json([
    'data'=>$trips,
    'totalPrice'=>$totalPrice,
]);  
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
