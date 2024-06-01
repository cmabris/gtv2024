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
            ->assertSet('editForm.role', $user->roles->first()->id)
            ->set('editForm.name', 'Nuevo Nombre')
            ->set('editForm.email', 'nuevo@ejemplo.com')
            ->set('editForm.email_confirmation', 'nuevo@ejemplo.com')
            ->set('editForm.password', 'nuevacontraseña')
            ->set('editForm.password_confirmation', 'nuevacontraseña')
            ->call('update', $user);

        $user->refresh();

        $this->assertEquals('Nuevo Nombre', $user->name);
        $this->assertEquals('nuevo@ejemplo.com', $user->email);
        $this->assertTrue(Hash::check('nuevacontraseña', $user->password));
    }
//EMAIL
    /** @test */
    public function test_email_is_required()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.email', '')
            ->call('update', $user)
            ->assertHasErrors(['editForm.email' => 'required']);
    }
    /** @test */
    public function test_email_must_be_confirmed()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.email', 'test@example.com')
            ->set('editForm.email_confirmation', 'different@example.com')
            ->call('update', $user)
            ->assertHasErrors(['editForm.email' => 'confirmed']);
    }
    /** @test */
    public function test_email_must_be_a_valid_email()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.email', 'invalid-email')
            ->set('editForm.email_confirmation', 'invalid-email')
            ->call('update', $user)
            ->assertHasErrors(['editForm.email' => 'email']);
    }
    /** @test */
    public function test_email_max_length()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.email', str_repeat('a', 46) . '@example.com')
            ->call('update', $user)
            ->assertHasErrors(['editForm.email' => 'max']);
    }
    /** @test */
    public function test_email_must_be_unique()
    {
        $existingUser = User::create([
            'name' => 'ExistingUser',
            'email' => 'existing@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igifasdfsaf', // password
        ]);
        $studentRole1 = \Spatie\Permission\Models\Role::create(['name' => 'Alumno1']);
        $existingUser->assignRole($studentRole1);


        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole2 = \Spatie\Permission\Models\Role::create(['name' => 'Alumno2']);
        $user->assignRole($studentRole2);


        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.email', 'existing@example.com')
            ->set('editForm.email_confirmation', 'existing@example.com')
            ->call('update', $user)
            ->assertHasErrors(['editForm.email' => 'unique']);
    }

//PASSWORD
    /** @test */
    public function password_is_required()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.password', '')
            ->call('update', $user)
            ->assertHasErrors(['editForm.password' => 'required']);
    }
    /** @test */
    public function password_must_be_confirmed()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.password', 'password')
            ->set('editForm.password_confirmation', 'different')
            ->call('update', $user)
            ->assertHasErrors(['editForm.password' => 'confirmed']);
    }
    /** @test */
    public function password_length_must_be_at_least_8_characters()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.password', 'shorttt')
            ->call('update', $user)
            ->assertHasErrors(['editForm.password' => 'min']);
    }
    /** @test */
    public function password_length_must_not_exceed_500_characters()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.password', str_repeat('a', 501))
            ->call('update', $user)
            ->assertHasErrors(['editForm.password' => 'max']);
    }

//NAME
    /** @test */
    public function name_is_required()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.name', '')
            ->call('update', $user)
            ->assertHasErrors(['editForm.name' => 'required']);
    }

//ROLE
    /** @test */
    public function role_is_required()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.role', '')
            ->call('update', $user)
            ->assertHasErrors(['editForm.role' => 'required']);
    }
    /** @test */
    public function role_must_exist_in_roles_table()
    {
        $adminUser = $this->createAdmin();

        $user = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $user->assignRole($studentRole);

        $nonExistingRoleId = 9999; // ID que no existe en la tabla roles

        Livewire::actingAs($adminUser)
            ->test(EditUser::class)
            ->call('openEditModal', $user)
            ->set('editForm.role', $nonExistingRoleId)
            ->call('update', $user)
            ->assertHasErrors(['editForm.role' => 'exists']);
    }


}


