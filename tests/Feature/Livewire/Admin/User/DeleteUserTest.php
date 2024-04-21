<?php

namespace Tests\Feature\Livewire\Admin\User;

use App\Http\Livewire\Admin\User\ListUsers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_deletes_a_user()
    {
        $adminUser = $this->createAdmin();
        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user2 = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($studentRole);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users',3);
        $this->assertDatabaseHas('users',[
           'id' => $user->id
        ]);

        $this->actingAs($adminUser);

        Livewire::test(ListUsers::class)
            ->call('show', $user)
            ->call('show', $user2);

        Livewire::test(ListUsers::class)
            ->call('delete',$user);

        $this->assertDatabaseCount('users',2);
    }
}
