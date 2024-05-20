<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TeacherRequest extends Component
{


    public function render()
    {
        return view('profile.teacher-request');
    }
}

