<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class TripCancel_admin extends Notification
{
    use Queueable;
    protected $driver;
    protected $trip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trip)
    {
     
        $this->trip=$trip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
     /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {

       $body=sprintf('لقد تم الغاء الرحلة من قبل السائق %s',$this->trip->full_name,);
        $url=sprintf(
            'http://127.0.0.1:8000/trips/%s',
            $this->trip->id,
           );
        return [
        'body'=>$body,
        'action'=>$url,
        ];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toFcm($notifiable)
    {

        $SERVER_API_KEY ='AAAAodUJ2Uw:APA91bEnqNHdJyE1_2V
        U5_hgQ-qcxORtNmHD8jaY-XJuWSgETr8P6lCv-5UQ9dRIa6hjnOWLBTaXR1W
        cncuRfqdrBSlwBIDRafs32MnuJxXO-6tjILuzrOEMiwMHh6nhjog3-kINlCJg';
       $body=sprintf('لقد تم الغاء الرحلة من قبل السائق %s',$this->trip->full_name,);
        $url=sprintf(
            'http://127.0.0.1:8000/trip/%s',
            $this->trip->id,
           );
        $data = [
            "to" => 'd0tLNPooSSaRwDhPmPH0pO:APA91bHSsEQVrrgBKWQQRy
            jbiRI82YirO9wmgWRixSeqdjfMlvdJNDKBafElatQ2AaToFNp6Qb1fJ
            JBOk179cvkA0E4tHb9ZYj2CE5ZS_wAcHvIjSLgPXaHnKxVoT1Ow6wuz
            y9duMNRh',
            "priority" => 'high',
            "notification" => [
                "title" =>$body,
                "body" => $url,
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
        print($response);
        return $response;

                }

    // optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
    public function fcmProject($notifiable, $message)
    {
        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }
}
