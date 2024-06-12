<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use App\Models\EmailForAdmin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Mail\UserPromotedToTeacher;

class EditUser extends Component
{
    public $roles, $userId, $avatarRoute;

    protected $listeners = ['openEditModal'];

    public $editForm = [
        'open' => false,
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => '',
    ];

    protected $rules = [
        'editForm.name' => 'required|string',
        'editForm.email' => 'required|string|max:45|unique:users,email',
        'editForm.password' => 'nullable|string|min:8|max:500',
        'editForm.role' => 'required|exists:roles,id',
    ];

    protected $validationAttributes = [
        'editForm.name' => 'nombre',
        'editForm.email' => 'email',
        'editForm.password' => 'contraseña',
        'editForm.role' => 'rol',
    ];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function openEditModal(User $user)
    {
        $this->reset(['editForm']);
        $this->reset(['avatarRoute']);

        $this->userId = $user->id;
        if ($user->profile_photo_path) {
            $this->avatarRoute = Storage::url($user->profile_photo_path);
        }
        $this->editForm['name'] = $user->name;
        $this->editForm['email'] = $user->email;
        $this->editForm['role'] = $user->roles->first()->id;
        $this->editForm['open'] = true;
    }

    public function update(User $user)
    {
        $this->rules['editForm.email'] = 'email|required|string|max:45|unique:users,email,' . $this->userId;

        $this->validate();

        $updateData = [
            'name' => $this->editForm['name'],
            'email' => $this->editForm['email'],
        ];

        if (!empty($this->editForm['password'])) {
            $updateData['password'] = bcrypt($this->editForm['password']);
        }

        $isUpdated = $user->update($updateData);

        $newRole = Role::findById($this->editForm['role']);
        $currentRole = $user->roles->first();

        $user->syncRoles($newRole);

        if ($isUpdated) {
            Log::info('User with ID ' . auth()->user()->id . ' edited the following user ' . $user);

            if ($newRole->name === 'Profesor' && (!$currentRole || $currentRole->name !== 'Profesor') && $user->requested_teacher_role) {
                Mail::to($user->email)->send(new UserPromotedToTeacher($user));

                $user->requested_teacher_role = false;
                $user->save();

                EmailForAdmin::where('user_id', $user->id)->delete();
            }
        }

        $this->editForm['open'] = false;
        $this->reset(['editForm']);
        $this->emitTo('admin.user.list-users', 'render');
        $this->emit('userUpdated');
    }

    public function render()
    {
        return view('livewire.admin.user.edit-user');
    }
}