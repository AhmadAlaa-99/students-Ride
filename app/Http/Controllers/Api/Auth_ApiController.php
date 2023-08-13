<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\student;
use App\Models\ForgetPassword;
use Illuminate\Http\Request;
use App\Mail\ForgottenPassword;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Auth_ApiController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     *//*
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
*/
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login_driver()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('driver-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function login_student()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('student-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function login_user()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function check()
    {
        if(Auth::guard('api')->check())
         {return 'driver';}
         else
         {
            return 'not driver';
         }
    }





    public function forgotPasswordCreate(Request $request)
    {
        $student=student::where('email',$request->email)->first();
        if($student)
        {
            //error : Property [email] does not exist on the Eloquent builder instance
            //solve : get email by array this error and not found get or fast 
            //$user=User::where(['email'=>$request->email]);
            //$user=User::where('email',$request->email)->first();
            $Password=ForgetPassword::updateOrCreate(
                ['email'=>$request->email],
                    [
                        'email'=>$request->email,
                        'token'=>random_int(1000,9999),
                    ]
                    ); 
           Mail::to($student->email)->send(new ForgottenPassword($Password));
          // $user->notify(new ResetPassword($user));
         return $this->sendResponse($Password, 'link reset sent');
        }
        else
        {
            return $this->sendError(' Error', ['error', 'Unauthorized']);
        }

     }






     public function forgotPasswordToken(Request $request)
     {
        $code=$request->token;
         $checkReset=ForgetPassword::where([
             'token'=>$code,
             'email'=>$request->email,
         ])->first();
         if(!$checkReset)
         {
             return 'details not match';
         }
         $student=student::where('email',$request->email)->first();
         if(!$student)
         {
             return 'user not found';
         }
         $student->password=$student->password=bcrypt($request->password);
         
         $student->save();
         $checkReset->delete();
         return $this->sendResponse($student, 'Reset Password Successfully!');

    }

}