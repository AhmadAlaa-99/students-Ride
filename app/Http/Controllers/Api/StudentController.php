<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\trip;
use App\Models\student;
use App\Models\suggestion;
use App\Models\student_trip;
use App\Models\User;
use App\Http\Controllers\BaseController;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\TripCancel_admin;
use App\Notifications\TripCancel_students;
use Carbon\Carbon;
use App\Notifications\status_TripStudents;
use App\Notifications\status_TripAdmin;
use Illuminate\Support\Arr;
use App\Notifications\Reservation_Confirm;



class StudentController extends BaseController
{ 
    
    public function Create_Profile(Request $request)
    {
        $validator=$request->validate([
            'full_name'=>'required',
            'email'=>'required|email',
            'password'=>'required|confirmed',
            'age'=>'required',
            'phone_number'=>'required',
            'gender'=>'required',
            'university'=>'required',
            'location'=>'required',
        
        ]);

        if (auth()->guard('student-api')->attempt($validator) || Student::where('email','=',$request->email)->first()){
            return response()->json([
                'status'=>false,
                 'message'=>'هذا الايميل موجود مسبقاً'
            ]);    
        }
        
        $student=new Student();
        $student->full_name=$request->full_name;
        $student->email=$request->email;
        $student->password=bcrypt($request->password);
        $student->gender=$request->gender;
        $student->phone_number=$request->phone_number;
        $student->age=$request->age;
        $student->university=$request->university;
        $student->location=$request->location;
     
        //save in database
         $student->save();
         //make token
        //VALIDATE DATA
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('student-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        //response
        return response()->json([
            'message'=>'تم إنشاء الحساب بنجاح',
            'status'=>true,
            'data'=>$student,
            'token'=>$token
        ],200);
    }
   
    public function Show_Profile ()
    {
        $student_id= auth()->guard('student-api')->id();
      
        $student=Student::where('id',$student_id)->first();
        return response()->json([
            'data'=>$student,
        ],200);
        
    }
    public function  Edit_Profile(Request $request)
    {
        $validator = $request->validate([
            'full_name',
            'email',
            'password'=>'confirmed',
            'age',
            'phone_number',
            'gender',
            'university',
            'location',
       ]); 
       if ( Student::where('email','=',$request->email)->first()){
        return response()->json([
            'status'=>false,
            'message'=>'هذا الايميل موجود مسبقاً'
        ]);    
    }
        $student_id= auth()->guard('student-api')->id();
        $student=Student::find($student_id);
        $student->full_name=isset($request->full_name) ? $request->full_name : $student->full_name;
        $student->email=isset($request->email) ? $request ->email : $student->email;
        $student->password=isset($request->password) ? bcrypt($request->password) : $student->password;
        $student->age=isset($request->gender) ? $request->age: $student->age;
        $student->phone_number=isset($request->phone_number) ? $request->phone_number: $student->phone_number;
        $student->gender=isset($request->gender) ? $request->gender: $student->gender;
        $student->university=isset($request->university) ? $request->university: $student->university;
        $student->location=isset($request->location) ? $request->location: $student->location;
        
        //save in database
        $student->save();
        //response date
        return response()->json([
            'status'=>true,
            "message"=>'تم تحديث معلومات الملف الشخصي بنجاح',
            'data'=>$student
        ],200);
    }
    //logout 
    public function  Delete_Profile()
    {
        $student_id= auth()->guard('student-api')->id();
    
        $student=Student::find($student_id);
        $student->delete();
        
        return response()->json([
            'status'=>true,
             'message'=>'تم حذف الحساب '
        ]);    
    }
   
    public function end_start_lines ()
    {
        $now = now()->format('H')+3;
        $nine_pm = '21';
        
        if ($now >= $nine_pm) {

            $now = Carbon::now();

            $tomorrow = $now->addDay();

            $tomorrow=$tomorrow->addDay();

            $tomorrow_str = $tomorrow->format('Y-m-d');

        
        }

        else {

        $now = Carbon::now();
       
        $tomorrow = $now->addDay();
       
        $tomorrow_str = $tomorrow->format('Y-m-d');

        }

        $source =   $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
        ->whereDate('trips.trip_date', '=', $tomorrow)->pluck('lines.start');
    

        $destination =   $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
        ->whereDate('trips.trip_date', '=', $tomorrow)->pluck('lines.end');
       

               return response()->json([
                'status'=>true,
                 'source'=>$source,
                 'destination'=>$destination,
            ]);  
        
    }
    public function information_of_trip(Request $request){
        $validator = $request->validate([
            'start'=>'required',
            'end'=>'required'
       ]); 

       $now = now()->format('H')+3;
       $nine_pm = '21';

       if ($now >= $nine_pm) {
        $now = Carbon::now();

        $tomorrow = $now->addDay();

        $tomorrow=$tomorrow->addDay();

        $tomorrow_str = $tomorrow->format('Y-m-d');

       }

      else {

       $now = Carbon::now();
       $tomorrow = $now->addDay();       
       $tomorrow_str = $tomorrow->format('Y-m-d');
        }


        $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
       ->whereDate('trips.trip_date', $tomorrow)
       ->where ('lines.start',$request->start)
       ->where ('lines.end',$request->end)
       ->select('trips.*','lines.*')
       ->get();

       return response()->json([
        'status'=>true,
         'information'=>$info,

    ]);
    }
    public function choose_The_Information_trip(Request $request,$id)
    {
        $trip=trip::where('id',$id)->first(); 

        $validator = $request->validate([
            'main_time' => [
                'required',
                Rule::in([$trip->time_1, $trip->time_2, $trip->time_3]),
            ],
            'time_desire_1' => [
                'required',
                Rule::in([$trip->time_1, $trip->time_2, $trip->time_3]),
                Rule::notIn([$main_time]),
            ],
            'time_desire_2' => [
                'required',
                Rule::in([$trip->time_1, $trip->time_2, $trip->time_3]),
                Rule::notIn([$main_time, $time_desire_1]),
            ],
        ]);
  
      
        $student_id= auth()->guard('student-api')->id();
        if (student_trip::where([['student_id','=',$student_id],['trip_id','=',$id]])->exists()){
            return response()->json([
                'status'=>false,
                 'message'=>'تم التسجيل على هذه الرحلة مسبقا',
            ]);
        }
        $student_trip = new student_trip();
        $student_trip->main_time=$request->main_time;
        $student_trip->time_desire_1=$request->time_desire_1;
        $student_trip->time_desire_2=$request->time_desire_2;
        $student_trip->trip_id=$id;
        $student_trip->student_id=$student_id;
        $student_trip->status=1;
        $date =trip::where('id','=',$id)->get('trip_date')->first();
        $student_trip->save();
        return response()->json([
            'status'=>true,
             'message'=>'تم حجز رحلة بنجاح',
             'data'=>$student_trip
            ]);
    }
    public function Cancel_Trip($id)
    {
        $student_id= auth()->guard('student-api')->id();
        if (!student_trip::where([['student_id','=',$student_id],['id','=',$id]])->exists()){
            return response()->json([
                'status'=>false,
                 'message'=>'هذه الرحلة غير موجودة',
                ]);     
        }
        $now = Carbon::now();
        $hour = $now->hour +3;
        if ($hour >= 21) {
         $student=student::find($student_id);
         $student->alert_count=$student->alert_count+1;
         $student->save();
         $trip=student_trip::where('id','=',$id)->first();
         $trip->delete();
         //delete account if conunt of alert big than 5
         if ($student->alert_count>=5){
           $this->Delete_Profile();
            return response()->json([
                'status'=>true,
                 'message'=>'تم حظر الحساب وذلك لتجاوز عدد مرات الالغاء بعد الساعه 9 مساء ال 5 مرات ',
                ]);
         }
         else {
         return response()->json([
            'status'=>true,
            'message'=>'تم الالغاء بنجاح',
            'عدد الانذارات'=>$student->alert_count
            ]);
        }
    }
        else {
            $trip=student_trip::where('id','=',$id)->first();
            $trip->delete();
            return response()->json([
                'status'=>true,
                 'message'=>'تم الالغاء بنجاح',
                 'time'=>$hour
                ]);
        }
       
    }
    public function Browse_my_Trips()
    {
        $student_id= auth()->guard('student-api')->id();
        $today = Carbon::now();
        $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
                ->join('drivers', 'trips.driver_id', '=', 'drivers.id')
                ->join('student_trip' , 'student_trip.trip_id','=','trips.id')
                ->where('student_trip.student_id', '=', $student_id)
                ->select('trips.*', 'lines.*','drivers.full_name as DriverName')
                ->get();
        
        
        return response()->json($info, 200);
    }

    
    public function show_my_current_trips()
    {
        $student_id= auth()->guard('student-api')->id();
        $today = Carbon::now();
        $info = trip::join('student_trip', 'trips.id', '=', 'student_trip.trip_id')
                ->join('drivers', 'trips.driver_id', '=', 'drivers.id')
                ->join('lines', 'trips.line_id','lines.id')
                ->where('trips.trip_date', '>', $today)
                ->where('student_trip.student_id', '=', $student_id)
                //->where('student_trip.status', '=', 'حالية')
                ->select('lines.*','trips.*', 'student_trip.*','drivers.full_name as DriverName')
                ->get();
       return response()->json([
        'status'=>true,
         'data'=>$info
    ]);  
    }
    
    public function show_details_for_trip($trip_id)
    {
        $student_id= auth()->guard('student-api')->id();
        if (!student_trip::where([['trip_id','=',$trip_id],['student_id','=',$student_id]])->exists()){
            return response()->json([
                 'status'=>false,
                 'message'=>'هذه الرحلة غير موجودة',
            ]); 
        }
        $today = Carbon::now();
        $info = trip::join('student_trip', 'trips.id', '=', 'student_trip.trip_id')
                ->join('drivers', 'trips.driver_id', '=', 'drivers.id')
                ->join('lines', 'trips.line_id','lines.id')
                ->where('trips.trip_date', '>', $today)
                ->where('student_trip.student_id', '=', $student_id)
                ->select('lines.*','trips.*', 'student_trip.*','drivers.full_name as DriverName')
                ->get()->first();
          return response()->json([
            'status'=>true,
            'data'=>$info
    ]);  
    }
    public function Send_Suggestion(Request $request,$trip_id)
    {
        
        $validator=$request->validate([
            'message'=>'required',
        ]);
        $student_id= auth()->guard('student-api')->id();
        if (!student_trip::where([['student_id','=',$student_id],['trip_id','=',$trip_id]])->exists()){
            return response()->json([
                'status'=>false,
                 'message'=>'لا تستطيع ارسال اقتراح عن هذه الرحلة لانك لم تكن مسجل فيها',
                ]);     
        }
        $suggestion = new suggestion();
        $suggestion->email=student::where('id','=',$student_id)->pluck('email')->first();
        $suggestion->body=$request->message;
        $suggestion->trip_id=$trip_id;
        $suggestion->save();
        return response()->json([
            'status'=>true,
             'message'=>'تم ارسال الاقتراح بنجاح',
             'data'=>$suggestion
        ]); 
        
    }
    public function Trips_Algorithm(){
        $now = now()->format('H')+3;
        $nine_pm = '11';

      if ($now >= $nine_pm) {
        $now = Carbon::now();

        $tomorrow = $now->addDay();

        $tomorrow_str = $tomorrow->format('Y-m-d');


        $trips=student_trip::join('trips','trips.id','=','student_trip.trip_id')
        ->where('trips.trip_date', '=', $tomorrow_str)->get();
        
        
        foreach($trips as $trip)
        {
            $count=count(student_trip::where('trip_id','=',$trip['trip_id'])->get());

            $trip_time1=trip::where('id',$trip['trip_id'])->pluck('trips.time_1');
            $main_time1=student_trip::where('main_time' , $trip_time1)->count();
            $desire_time1=student_trip::where('time_desire_1' , $trip_time1)->count();
            $desire2_time1=student_trip::where('time_desire_2' , $trip_time1)->count();
            
            
            $time1=max($main_time1,$desire_time1,$desire2_time1);


            $trip_time2=trip::where('id',$trip['trip_id'])->pluck('trips.time_2');
            $main_time2=student_trip::where('main_time' , $trip_time1)->count();
            $desire_time2=student_trip::where('time_desire_1' , $trip_time2)->count();
            $desire2_time2=student_trip::where('time_desire_2' , $trip_time2)->count();

            $time2=max($main_time2,$desire_time2,$desire2_time2);


            $trip_time3=trip::where('id',$trip['trip_id'])->pluck('trips.time_3');
            $main_time3=student_trip::where('main_time' , $trip_time3)->count();
            $desire_time3=student_trip::where('time_desire_1' , $trip_time3)->count();
            $desire2_time3=student_trip::where('time_desire_2' , $trip_time3)->count();

            $time3=max($main_time3,$desire_time3,$desire2_time3);
        
            $trip_main_time=trip::where('id',$trip['trip_id'])->first();
            if ($time1 >= $time2 && $time1 >= $time3){
                $trip_main_time->time_final=$trip_time1->first();
                $trip_main_time->save();
            }
            if ($time2 > $time1 && $time2 >= $time3){
                $trip_main_time->time_final=$trip_time2->first();
                $trip_main_time->save();
            }
            if ($time3 > $time1 && $time3 > $time2){
                $trip_main_time->time_final=$trip_time3->first();
                $trip_main_time->save();
            }
               
            $tripId=$trip->id;
            $students=student::where('id',$trip['student_id'])->get();
            \Notification::send($students,new Reservation_Confirm($trip));
            /*
            $students=student::whereHas('trips', function ($query) use ($tripId) {
                $query->where('trip_id',$tripId);
            })->get();
            */

                   
           
       }
       
   }
    }
    public function browse_Notification ()
    {
        $student=student::where('id',Auth::guard('student-api')->id())->first();
        $notification=$student->unreadNotifications;
          return $this->sendResponse($notification,'student Notifications');
    }
    public function Forget_Password(){}     
    
    public function browse_the_map(){}

    public function All_inforamtion_of_trip($id){
        

        $trip_info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
                          ->where('trips.id', '=', $id)->first();

        
       return response()->json([
        'status'=>true,
        'trip_info'=>$trip_info,
    
    ]);  
    }

}
