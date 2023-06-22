<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\trip;
use App\Models\student;
use App\Models\student_trip;
use App\Models\User;
use App\Http\Controllers\BaseController;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\TripCancel_admin;
use App\Notifications\TripCancel_students;

use App\Notifications\status_TripStudents;
use App\Notifications\status_TripAdmin;

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
                 'message'=>'The email has already been taken'
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
            'message'=>'register successfully',
            'status'=>true,
            'data'=>$student,
            'token'=>$token
        ],200);
    }
   
    public function Show_Profile ()
    {
        $student_id= auth()->guard('student-api')->id();
      
        $student=Student::where('id',$student_id)->first();
        return $this->sendResponse($student, 'profile');
        
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
             'message'=>'The email has already been taken'
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
            "message"=>'profile updated successful',
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
             'message'=>'successfully'
        ]);    
    }
   
    public function choose_The_Information_trip ()
    {
        
    }
    public function Cancel_Trip()
    {
        
    }
    public function Browse_my_Trips()
    {
        $student_id= auth()->guard('student-api')->id();
        $data = trip::get();
        return response()->json($data, 200);
    }
    public function FeedBack()
    {
        
    }
   
    public function Brows_The_Map()
    {
        
    }
    public function Send_Suggestion()
    {
        
    }
    public function browse_Notification ()
    {
        
    }
    public function LogOut ()
    {
        
    }
    public function Forget_Password()
    {
        
    }
   

}
