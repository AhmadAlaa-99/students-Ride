<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class status_TripAdmin extends Notification
{
    use Queueable;
    protected $trip;
    protected $driver;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trip,$driver)
    {
        $this->trip=$trip;
        $this->driver=$driver;
        //
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
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toDatabase($notifiable)
    {
        $body=sprintf('تم تحديث حالة الرحلة من قبل السائق %s',$this->driver->full_name);
         $url=sprintf(
             'http://127.0.0.1:8000/trips/%s',
             $this->trip->id,
            );
            
         return [
         'body'=>$body,
         'action'=>$url,
         ];
    }
}
