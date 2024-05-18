<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateGtvisorUser extends Component
{
    public $confirmingUserDeletion = false;

    public function confirmChangeUser()
    {
        $this->confirmingUserDeletion = true;
    }

    public function changeUser()
    {
        $user = Auth::user();
        if ($user) {
          
            $previousRole = $user->getRoleNames()->first();
            $user->previous_role = $previousRole;
            $user->save();

            $user->syncRoles(['GTVisor']);
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

