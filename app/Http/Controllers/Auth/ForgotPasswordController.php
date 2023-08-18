<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\ForgetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\ForgottenPassword;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function getEmail()
    {
            return view('auth.passwords.email');
    }
    public function postEmail(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if($user)
        {
            $ResetPassword=ForgetPassword::updateOrCreate(
                ['email'=>$request->email],
                    [
                        'email'=>$request->email,
                        'token'=>random_int(1000,9999),
                    ]
                    ); 
           Mail::to($user->email)->send(new ForgottenPassword($ResetPassword));
        }
        else
        {
           //email error not found
        }
        return view('auth.passwords.confirm_code');

    }
    public function confirm_code(Request $request)
    {   
        $code=$request->code;
        $checkReset=ForgetPassword::where([
            'token'=>$code,
          //  'email'=>$request->email,
        ])->first();
        $email=$checkReset->email;

        if(!$checkReset)
        {
            return 'Error Code';
        }
        return view('auth.passwords.reset',compact('email'));

    }

    public function update_password(Request $request)
    {   
        $validator=Validator::make( $request->all(),
        [
            'password'=>'required',
            'password_confirmation'=>'required|same:password'
        ]);

        $email=$request->email;
      // return $request->password;
       
         $user=User::where('email',$email)->first();

         if(!$user)
         {
             return 'user not found';
         }
         $user->password=Hash::make($request->password);
         
         $user->save();
         return redirect()->route('login');

    }


}