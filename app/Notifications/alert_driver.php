<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class alert_driver extends Notification
{
    public function __construct($driver) 
    { 
        $this->driver=$driver; 
    } 

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }
    public function toFcm($notifiable)
    {
        $SERVER_API_KEY = 'AAAAwjICafo:APA91bGl4kOs_x7Wl9
        wdFaOkcJSorNZsXdvT_durj5fG6bu
        21wE6r5_vvRY9tHi_NIPhdcNuD
        4CeIq2F_dlLzTnU-PX9qQCtLGvHbUE9_69j
        lvoXaIUQ1OczlEeVoFOOvB9HqBGDIZVf';
        $data = [
            "to" => 'd0tLNPooSSaRwDhPmPH0pO:APA91bHSsEQVrrgBKWQQRyjbiRI82YirO
            9wmgWRixSeqdjfMlvdJNDKBafElatQ2AaToFNp6Qb1fJJBOk179cvkA0E4tHb9Z
            Yj2CE5ZS_wAcHvIjSLgPXaHnKxVoT1Ow6wuzy9duMNRh',
            "priority"=>'high',
            "notification" => [
                "title" => 'hello khaled',
                "body" => 'hello khaled',
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

if ($response === false) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    echo 'Response: ' . $response;
}
        /*
        $deviceToken= $this->driver->deviceToken;
        $title="hello";
        $body="test";
        return FcmMessage::create()
            ->setData(['to' =>'d0tLNPooSSaRwDhPmPH0pO:APA91bHSsEQVrrgBKWQQRyjbiRI82YirO9wmgWRixSeqdjfMlvdJNDKB
            afElatQ2AaToFNp6Qb1fJJBOk179cvkA0E4tHb9ZYj2CE5ZS_wAcHvIjSLgPXaHnKxVoT1Ow6wuzy9duMNRh', 'priority' => 'high'])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Account Activated')
                ->setBody('Your account has been activated.')
                ->setImage('http://example.com/url-to-image-here.png'))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
                    $data = [
                        "to" => 
                        'd0tLNPooSSaRwDhPmPH0pO:APA91bHSsEQVrrgBKWQQRyjbiRI82YirO9wmgWRixSeqdjfMlvdJNDKBafElatQ2AaToFNp6Qb1fJJBOk179cvkA0E4tHb9ZYj2CE5ZS_wAcHvIjSLgPXaHnKxVoT1Ow6wuzy9duMNRh',
                        "priority"=>'high',
                        "notification" => [
                            "title" => $title,
                            "body" => $body,
                        ]
                    ];
                    $dataString = json_encode($data); 
                    $headers = [ 
                        'Authorization: key=' . $SERVER_API_KEY, 
                        'Content-Type: application/json', 
                    ]; 
                    $ch = curl_init(); 
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send'); 
                    curl_setopt($ch, CURLOPT_POST, true); 
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString); 
                    $response = curl_exec($ch); 
                    if ($response === false) { 
                        echo 'cURL error: ' . curl_error($ch); 
                    } else { 
                        echo 'Response: ' . $response; 
                    } 
*/


                }

    // optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
    public function fcmProject($notifiable, $message)
    {
        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }
}

/*
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class alert_driver extends Notification
{
    use Queueable;

  
    public function __construct()
    {
        //
    }

  
    public function via($notifiable)
    {
        return ['database'];
    }

  
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
          
            'title'=>'تنبيه - لقد تعرضت لحالة انذار من قبل الشركة ',
          
        ];
    }
}
*/

