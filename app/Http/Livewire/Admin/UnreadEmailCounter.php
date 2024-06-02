<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\EmailForAdmin;

class UnreadEmailCounter extends Component
{

    public function showEmails()
    {
        $emailCount = EmailForAdmin::count();
        $emails = EmailForAdmin::all();

        return view('livewire.admin.unread-email-counter', compact('emailCount', 'emails'));
    }

    public function render()
    {
        return view('livewire.admin.unread-email-counter', [
            'emailCount' => EmailForAdmin::count(),
            'emails' => EmailForAdmin::all()
        ]);
    }

}