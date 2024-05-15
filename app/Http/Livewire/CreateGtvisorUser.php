<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CreateGtvisorUser extends Component
{
    public $confirmingUserDeletion = false;
    public $password;

    public function updateRole()
    {
        $user = Auth::user();
        if ($user) {
            $user->syncRoles(['gtvisor']);

            session()->flash('message', 'Role updated successfully.');
        } else {
            session()->flash('error', 'User not found.');
        }
    }

    public function confirmChangeUser()
    {
        $this->confirmingUserDeletion = true;
    }

    public function changeUser()
    {
        $user = Auth::user();
        
            if ($user) {
                $user->syncRoles(['gtvisor']);
                session()->flash('message', 'Role updated successfully.');
                return redirect()->route('welcome'); 
            } else {
                session()->flash('error', 'User not found.');
            }
    
        $this->confirmingUserDeletion = false;
    }

    public function render()
    {
        return view('profile.create-gtvisor-user');
    }
}