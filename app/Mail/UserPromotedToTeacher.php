<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class UserPromotedToTeacher extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('email.user-promoted-to-teacher')
                    ->subject('Enhorabuena, ahora eres profesor!')
                    ->with([
                        'user' => $this->user,
                    ]);
    }
}
