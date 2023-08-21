<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use App\Http\Controllers\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\DeviceToken;
use App\Models\student;
use App\Models\driver;

class BaseController
{
  public function sendResponse($result,$message)
  {
       $response=[
           'success'=>true,
           'data'=>$result,
           'message'=>$message
       ];
       return response()->json($response,200);

  }
  public function sendError($error,$errorMessage=[],$code=404)
  {
       $response=[
           'success'=>false,
           'message'=>$error
       ];
       if(!empty($errorMessage))
       {
           $response['data']=$errorMessage;
       }
       return response()->json($response,$code);

  }
  public function sendFCMNotification($type,$userId, $title, $body)
    {
        if($type=='driver')
        {
            $user =driver::where('id',$userId)->first();
        }
        else
        {
            $user =student::where('id',$userId)->first();
        }

      $deviceTokens =DeviceToken::where('email',$user->email)->get();
      foreach($deviceTokens as $deviceToken)
      {
        $SERVER_API_KEY = 'AAAAwjICafo:APA91bGl4kOs_x7Wl9wdFaOkcJSorNZsXdvT_durj5fG6bu21wE6r5_v
        vRY9tHi_NIPhdcNuD4CeIq2F_dlLzTnU-PX9qQCtLGvHbUE9_69jlvoXaIUQ1OczlEeVoFOOv
        B9HqBGDIZVf';    
        $data = [
            "to" => $deviceToken->fcm_token,
            "priority" => 'high',
            "notification" => [
                "title" => $title,
                "body" => $body,
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json', ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        print($response);

      }
       
    }

}
