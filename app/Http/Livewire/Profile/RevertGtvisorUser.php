<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RevertGtvisorUser extends Component
{
    public $confirmingUserReversion = false;

    public function confirmRevertUser()
    {
        $this->confirmingUserReversion = true;
    }

    public function revertUser()
    {
        $user = Auth::user();
        if ($user) {
            
            $previousRole = $user->previous_role ?? 'GTVisor'; 

            $user->syncRoles([$previousRole]);
            session()->flash('message', 'Role reverted successfully.');
            return redirect()->route('welcome');
        } else {
            session()->flash('error', 'User not found.');
        }

        $this->confirmingUserReversion = false;
    }

    public function render()
    {
        return view('profile.revert-gtvisor-user');
    }
}
