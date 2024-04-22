<?php

namespace Tests\Feature\Livewire\Admin\User;

use App\Http\Livewire\Admin\User\EditUser;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;

class UpdateUserTest extends TestCase
{
    /** @test */
    public function it_can_update_a_user()
    {
        $adminUser = $this->createAdmin();
        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'), // Cifra la contraseña utilizando bcrypt
        ]);

        $user->assignRole($studentRole);

        $this->actingAs($adminUser);

        Livewire::test(EditUser::class)
            ->call('openEditModal', $user)
            ->assertSet('editForm.name', $user->name)
            ->assertSet('editForm.email', $user->email)
            ->assertSet('editForm.email_confirmation', $user->email)
            ->assertSet('editForm.password', $user->password)
            ->assertSet('editForm.role', $user->roles->first()->id);

        // Simular la actualización del usuario
        $userToUpdate = User::find($user->id);
        $userToUpdate->name = 'Nuevo Nombre';
        $userToUpdate->email = 'nuevo@ejemplo.com';
        $userToUpdate->password = bcrypt('nuevacontraseña');
        $userToUpdate->save();

        $userToUpdate->refresh();

        $this->assertEquals('Nuevo Nombre', $userToUpdate->name);
        $this->assertEquals('nuevo@ejemplo.com', $userToUpdate->email);
        $this->assertTrue(Hash::check('nuevacontraseña', $userToUpdate->password));
    }
}

