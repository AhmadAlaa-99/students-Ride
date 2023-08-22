<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\Reservation_Confirm;
use Validator;
use App\Models\UserActivateToken;
use App\Models\password_confirmation;
use App\Mail\delete_profile_student;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\NotIn;
use App\Notifications\ActivateEmail;
use App\Mail\RegisterUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\driver;
use App\Models\trip;
use App\Models\line;
use App\Models\student;
use App\Models\suggestion;
use App\Models\student_trip;
use App\Models\User;
use App\Http\Controllers\BaseController;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\TripCancel_admin;
use App\Notifications\TripCancel_students;
use App\Notifications\Reservation_Confirm_admin;

use Carbon\Carbon;
use App\Notifications\status_TripStudents;
use App\Notifications\status_TripAdmin;
use Illuminate\Support\Arr;

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
         
         $code=random_int(1000,9999);
         $newToken=new UserActivateToken();
         $newToken->student_id=$student->id;
         $newToken->code=$code;
         $newToken->save();
         Mail::to($student->email)->send(new RegisterUserMail($student,$code));
         
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

    public function ActivateEmail(Request $request)
    {
        $checkToken=UserActivateToken::where(['code'=>$request->code])->first();
        if ($checkToken) 
        {
            $student_id=$checkToken->student_id;
            $studen=student::where(['id'=>$student_id])->first();
            $studen->email_verified_at=Carbon::now();
            $studen->save();
            $studen->notify(new ActivateEmail($studen));
            return response()->json([
                'status'=>true,
                'message'=>'تم تفعيل الحساب بنجاح'
            ]);   
        }
        else 
        {
            return response()->json([
                'status'=>false,
                'message'=>'خطأ في الكود'
            ]); 

        }
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
      /*

        $now = now()->format('H')+3;
        $nine_pm = '01';

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
        
        
        $source =   $info = line::join('trips', 'trips.line_id', '=', 'lines.id')
        ->whereDate('trips.trip_date', '=', $tomorrow)->distinct('lines.start')->pluck('lines.start');
        */
        
       $source =$info =line::pluck('lines.start');
        
      
       //  $destination =   $info = trip::join('lines', 'trips.line_id', '=', 'lines.id') 
        // ->whereDate('trips.trip_date', '=', $tomorrow)->distinct('lines.start')->pluck('lines.end');
         
       $destination =$info =line::pluck('lines.end');
                return response()->json([
                 'status'=>true,
                  'source'=>$source,
                  'destination'=>$destination,
             ]);  
    }
    public function information_of_trip(Request $request){
        try {
            $request->validate([
                'start' => 'required',
                'end' => 'required|different:start',
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
           ->where ('trips.status','قادمة')
           ->select('trips.id as trip_id', 'trips.*', 'lines.*')
           ->get();
           return response()->json([
            'status'=>true,
             'information'=>$info,
        ]);  
        } catch (Illuminate\Validation\ValidationException $exception) {
            $errors = $exception->validator->errors()->all();
            return response()->json([
                'status' => false,
                'message' => $errors[0], 
            ]);
        }
       
    }
    public function choose_The_Information_trip(Request $request,$id)
    {
        $trip=trip::where('id',$id)->first();
        /*
        $validator =   $request->validate([
            'main_time' => ['required', new In([$trip->time_1, $trip->time_2, $trip->time_3])],
            'time_desire_1' => [
                'required',
                new In([$trip->time_1, $trip->time_2, $trip->time_3]),
                new NotIn([$request->input('main_time')]),
            ],
            'time_desire_2' => [
                'required',
                new In([$trip->time_1, $trip->time_2, $trip->time_3]),
                new NotIn([$request->input('main_time'), $request->input('time_desire_1')]),
            ],
        ]);
        */
        
      $now = Carbon::now();

      $tomorrow = $now->addDay();

      $tomorrow_str = $tomorrow->format('Y-m-d');
      $count=count(student_trip::where('trip_id','=',$id )->get());
      $num_str=trip::where('id',$id)->pluck('num_stu')->first();
            
      if ($count >= $num_str){
          return response()->json([
              'status'=>false,
               'message'=>'نعتذر الباص قد امتلأ',
          ]);
      }
      else 
      {
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
        $student_trip->status=0;
        $date =trip::where('id','=',$id)->get('trip_date')->first();
        $student_trip->save();
        $title=sprintf('تأكيد الحجز');
        $body=sprintf('تم حجز الرحلة بنجاح , سيصلك تأكيد بالوقت بعد التاسعة ');
        $this->sendFCMNotification('student',$student_id,$title,$body);
        return response()->json([
            'status'=>true,
             'message'=>'تم حجز رحلة بنجاح',
             'data'=>$student_trip
            ]);
    }
}
/*
    public function Cancel_Trip($id)
    { 
        $student_id= auth()->guard('student-api')->id();
       
        if (!student_trip::where([['student_id','=',$student_id],['trip_id','=',$id]])->exists())
        {
            return response()->json([
                'status'=>false,
                 'message'=>'هذه الرحلة غير موجودة',
                ]);     
        }
        $now = Carbon::now();
        $hour = $now->hour +3;
        $student=student::find($student_id);
        $student->alert_count=$student->alert_count+1;
        $student->save();
       
        $student_trip=student_trip::where(
            ['trip_id'=>$id,
              'student_id'=>$student->id,
            ])->first();
            return $student_trip;
        $student_trip->delete();
        $admin=User::first();
        if ($hour >= 21)
         {
         //delete account if conunt of alert big than 5
         if ($student->alert_count>=5)
         {
            //notify email student 
            Mail::to($student->email)->send(new delete_profile_student($student));
           $this->Delete_Profile();
            return response()->json([
                'status'=>true,
                 'message'=>'تم حظر الحساب وذلك
                  لتجاوز عدد
                  مرات الالغاء بعد الساعه 9 مساء ال 5 مرات ',
                ]);
         }
         else {
            //notify student to attention account_alert
            $title=sprintf('انذار جديد');
            $body=sprintf('تلقيت انذار جديد لديك %s انذارات',$student->alert_count,);
        //  \Notification::send($driver,new alert_driver($driver));
            $this->sendFCMNotification('student',$student->id,$title,$body);
     //       \Notification::send($student,new attention_alert_student($student)); 
        
         return response()->json([
            'status'=>true,
            'message'=>'تم الالغاء بنجاح',
            ]);
        }
    }
        else {
            $trip=student_trip::where('trip_id','=',$id)->first();
            $trip->delete();
            return response()->json([
                'status'=>true,
                 'message'=>'تم الالغاء بنجاح',
                 'time'=>$hour
                ]);
        }
       
    } */
    public function Cancel_Trip($id)
    { 
        $student_id= auth()->guard('student-api')->id();
       
        if (!student_trip::where([['student_id','=',$student_id],['trip_id','=',$id]])->exists())
        {
            return response()->json([
                'status'=>false,
                 'message'=>'هذه الرحلة غير موجودة',
                ]);     
        }
        $now = Carbon::now();
        $hour = $now->hour +3;
        $student=student::find($student_id);
        $student->alert_count=$student->alert_count+1;
        $student->save();
       
        $student_trip=student_trip::where(
            ['trip_id'=>$id,
              'student_id'=>$student->id,
            ])->first();

        $student_trip->delete();
        $admin=User::first();
        if ($hour >= 19)
         {
         //delete account if conunt of alert big than 5
         if ($student->alert_count>=5)
         {
     
           $student->delete();
            return response()->json([
                'status'=>true,
                 'message'=>'تم حظر الحساب وذلك
                  لتجاوز عدد
                  مرات الالغاء بعد الساعه 9 مساء ال 5 مرات ',
                ]);
         }
         else {
            //notify student to attention account_alert
            $title=sprintf('انذار جديد');
            $body=sprintf('تلقيت انذار جديد لديك %s انذارات',$student->alert_count,);
        //  \Notification::send($driver,new alert_driver($driver));
            $this->sendFCMNotification('student',$student->id,$title,$body);
     //       \Notification::send($student,new attention_alert_student($student)); 
        
         return response()->json([
            'status'=>true,
            'message'=>'تم الالغاء بنجاح',
            ]);
        }
    }
}
    public function Browse_my_Trips()
    {
        $student_id= auth()->guard('student-api')->id();
        $today = Carbon::now();
        $info = trip::join('lines', 'trips.line_id', '=', 'lines.id')
        ->join('drivers', 'trips.driver_id', '=', 'drivers.id')
        ->join('student_trip', 'student_trip.trip_id', '=', 'trips.id')
        ->where('student_trip.student_id', '=', $student_id)
        ->select('lines.*','trips.*', 'student_trip.*','drivers.full_name as DriverName',
        'trips.status as status_trip','drivers.status as status_driver','trips.id as trip_id')
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
                ->where('student_trip.student_id', '=', $student_id)
                ->whereIn('trips.status', ['حالية', 'قادمة'])
                ->select('trips.id as trip_id','lines.*','trips.*', 'student_trip.*','drivers.full_name as DriverName',
                'trips.status as status_trip','drivers.status as status_driver')
                ->get();

       return response()->json([
        'status'=>true,
         'data'=>$info
    ]);  
    }
    
    public function show_details_for_trip($trip_id)
    {
        $student_id= auth()->guard('student-api')->id();
        $count = student_trip::where('trip_id', $trip_id)
                    ->where('student_id', $student_id)
                    ->count();

        if ($count == 0)
        {
            return response()->json([
                 'status'=>false,
                 'message'=>'هذه الرحلة غير موجودة',
            ]); 
        }
        $today = Carbon::now();
        $info = trip::join('student_trip', 'trips.id', '=', 'student_trip.trip_id')
                ->join('drivers', 'trips.driver_id', '=', 'drivers.id')
                ->join('lines', 'trips.line_id','lines.id')
              //  ->where('trips.trip_date', '>', $today)
                // ->whereIn('trips.status', ['حالية', 'قادمة'])
                ->where('student_trip.student_id', '=', $student_id)
                ->select('trips.id as trip_id','lines.*','trips.*', 'student_trip.*','drivers.full_name as DriverName',
                'trips.status as status_trip','drivers.status as status_driver')
                ->first();
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
        ->where('trips.id', '=', $id)
        ->select('trips.id as trip_id', 'lines.*')
        ->first();

        
       return response()->json([
        'status'=>true,
        'trip_info'=>$trip_info,
    
    ]);  
    }
    public function Trips_Algorithm()
    {
  $now = Carbon::now();

  $tomorrow = $now->addDay();

  $tomorrow_str = $tomorrow->format('Y-m-d');

  $trips=student_trip::join('trips','trips.id','=','student_trip.trip_id')
  ->where('trips.trip_date', '=', $tomorrow_str)->get();
  
  $now = Carbon::now();

  $tomorrow = $now->addDay();
  $tomorrow_str = $tomorrow->format('Y-m-d');
  $trips=trip::where(
    ['trip_date'=> $tomorrow_str,
    'status'=>'قادمة'
    ]
    )->has('studentTrips')->get();

   
  foreach($trips as $trip)
  {
    
    $students_trip=student_trip::where('trip_id','=',$trip->id)->get();
    $trip_date=$trip->trip_date;
    foreach($students_trip as $student_trip )
    {
        $trip_time1=trip::where('id',$trip->id)->pluck('trips.time_1');
  
       
        $main_time1=$student_trip->where('main_time' , $trip_time1)->count();
        $desire_time1=$student_trip->where('time_desire_1' , $trip_time1)->count();
        $desire2_time1=$student_trip->where('time_desire_2' , $trip_time1)->count();
        
        $time1=max($main_time1,$desire_time1,$desire2_time1);
  

        $trip_time2=trip::where('id',$trip->id)->pluck('trips.time_2');

        $main_time2=$student_trip->where('main_time' , $trip_time1)->count();
        $desire_time2=$student_trip->where('time_desire_1' , $trip_time2)->count();
        $desire2_time2=$student_trip->where('time_desire_2' , $trip_time2)->count();

  
        $time2=max($main_time2,$desire_time2,$desire2_time2);

        $trip_time3=trip::where('id',$trip->id)->pluck('trips.time_3');
        $main_time3=$student_trip->where('main_time' , $trip_time3)->count();
        $desire_time3=$student_trip->where('time_desire_1' , $trip_time3)->count();
        $desire2_time3=$student_trip->where('time_desire_2' , $trip_time3)->count();
        $time3=max($main_time3,$desire_time3,$desire2_time3);
        $trip_main_time=trip::where('id',$trip->id)->first();
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
    }
    $trip_id=$trip->id;
      $students = Student::whereHas('trips', function ($query) use($trip_id) {
        $query->where('trip_id', $trip_id);
    })->get();

    $trip_info = trip::join('lines', 'trips.line_id', '=', 'lines.id') 
    ->where('trips.id', '=', $trip_id)
    ->select('trips.id as trip_id', 'lines.*','trips.*')
    ->first();
      $title=sprintf('رحلة مجدولة');
      $body=sprintf('كن مستعد - الرحلة %s - %s - %s في الساعة %s صباحا',
      $trip_info->start,$trip_info->end,$trip_info->price,$trip_info->time_final);
   
      foreach($students as $student)
      {
     
          $this->sendFCMNotification('student',$student->id,$title,$body);     
      }
 
    
       $admin=User::first();
      \Notification::send($admin, new Reservation_Confirm_admin($trip_info));
    
 }
    }
}