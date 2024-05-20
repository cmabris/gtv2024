<?php

namespace App\Http\Livewire\Profile;

use App\Mail\UserCreated;
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

            Mail::to('admin@mail.com')->send(new UserCreated($user));

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

