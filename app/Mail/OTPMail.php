<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $user;


    public function __construct($token, $user){
        $this->token =  $token;
        $this->user =  $user;
    }


    public function build(){
        return $this->view("OTP")
            ->with(['token' => $this->token]);
    }
}

