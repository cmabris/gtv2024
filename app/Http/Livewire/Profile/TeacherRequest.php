<?php

namespace App\Http\Livewire\Profile;

use App\Mail\TeacherRequest as Teacher;
use App\Models\EmailForAdmin;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TeacherRequest extends Component
{
    public $SendEmailToAdmin = false;

    public function confirmSendEmail()
    {
        $this->SendEmailToAdmin = true;
    }

    public function sendEmail()
    {
        $user = Auth::user();

        if ($user) {
            $sender = $user->email;
            $mail = Mail::to('admin@mail.com')->send(new Teacher($user));
            $mailBody = $mail->getMessage()->toString();
            EmailForAdmin::create([
                'body' => $mailBody,
                'from' => $sender,
            ]);
            return redirect()->route('welcome');
        } else {
            session()->flash('error', 'User not found.');
        }

        $this->SendEmailToAdmin = false;
    }

    public function render()
    {
        return view('profile.teacher-request');
    }
}

