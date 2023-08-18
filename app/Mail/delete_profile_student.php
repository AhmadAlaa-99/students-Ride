<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class delete_profile_student extends Mailable
{
    use Queueable, SerializesModels;
    protected $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student)
    {
        $this->student=$student;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        $student=$this->ResetPassword->token;
       // $url=url(path:'api/forgotpassword/'.$this->ResetPassword->token);
        return $this->from(address:'student_ride@gmai.com')->view(view:'mail.delete_profile')->with([
            'student'=>$this->student->email,
             //'url'>=$url,
            
        ]);
       // return $this->view(view:'view.name');
    }
    public function envelope()
    {
        return new Envelope(
            subject: 'Delete Profile Student',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
