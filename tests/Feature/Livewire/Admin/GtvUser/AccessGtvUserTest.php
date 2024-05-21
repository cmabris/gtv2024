<?php

namespace Tests\Feature\Livewire\Admin\GtvUser;

use App\Http\Livewire\Admin\User\CreateUser;
use App\Http\Livewire\Profile\CreateGtvisorUser;
use App\Http\Livewire\Profile\RevertGtvisorUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AccessGtvUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test*/
    public function can_change_user_to_gtv_user_and_rollback()
    {
        Role::create(['name' => 'GTVisor']);
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Alumno']);

        $user->assignRole($role);

        Livewire::test(CreateUser::class)
            ->set('createForm.name', $user->name)
            ->set('createForm.email', $user->email)
            ->set('createForm.password', $user->password)
            ->set('createForm.role', $role->id)
            ->call('save');

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get('/user/profile');

        $response->assertSee('Change to a GTVisor user.');

        // cambiamos de alumno -> gtvisor
        Livewire::test(CreateGtvisorUser::class)
            ->call('confirmChangeUser')
            ->assertSet('confirmingUserDeletion', true)
            ->set('confirmingUserDeletion', false)
            ->call('changeUser');

        $response2 = $this->actingAs($user)->get('/user/profile');
        $response2->assertSee('Revert to User');

        // regresamos de gtvisor -> alumno
        Livewire::test(RevertGtvisorUser::class)
            ->call('confirmRevertUser')
            ->assertSet('confirmingUserReversion', true)
            ->set('confirmingUserReversion', false)
            ->call('revertUser');

        $response3 = $this->actingAs($user)->get('/user/profile');
        $response3->assertSee('Change to a GTVisor user.');
    }

}
