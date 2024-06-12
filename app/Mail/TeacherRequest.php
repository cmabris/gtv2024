<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherRequest extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct( $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $user = $this->user;

        return $this->subject('Peticion de usuario')->view('email.teacher-request', compact('user'));
    }
}
