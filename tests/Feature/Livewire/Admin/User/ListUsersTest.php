<?php

namespace Tests\Feature\Livewire\Admin\User;

use App\Livewire\Admin\User\ListUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_see_the_users()
    {
        $adminUser = $this->createAdmin();
        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $teacherRole = Role::create(['name' => 'Profesor']);

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
        $user2->assignRole($teacherRole);

        $this->assertDatabaseCount('users',3);

        $this->actingAs($adminUser);

        Livewire::test(ListUsers::class)
            ->call('show', $user)
            ->call('show', $user2);
    }
}
