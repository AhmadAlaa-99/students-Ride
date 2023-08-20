<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;



class alert_driver extends Notification
{
    protected $driver;
    public function __construct($driver) 
    { 
       $this->driver=$driver; 
    } 

    
    public function via($notifiable)
    {
        //return [FcmChannel::class];
        return ['database'];
    }
/*
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['data1' => 'value', 'data2' => 'value2'])
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
    }

    public function toDatabase($notifiable)
    {

       $body=sprintf('تلقيت انذار جديد لديك %s انذارات',$this->driver->alert_count,);
    
        $url=sprintf(
            'http://127.0.0.1:8000/trip/%s',
            $this->trip->id,
           );
           
        return [
        'body'=>$body,
       // 'action'=>$url,
        ];
    }
    

    // optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
    public function fcmProject($notifiable, $message)
    {
        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }
    */

}