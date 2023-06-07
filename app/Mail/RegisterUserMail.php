<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterUserMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $student,$token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student,$token)
    {
        $this->student=$student;
        $this->token=$token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$url=url(path:'api/activate/'.$this->token);
        $code=$this->token;
        return $this->from(address:'ahmad@gmai.com')->view(view:'mail.register')->with([
            'name'=>$this->student->full_name,
         // 'url'=>$url,
         'code'=>$code,
        ]);
    }
}
