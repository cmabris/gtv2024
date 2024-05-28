<?php

namespace Tests\Feature\Livewire\Admin\User;

use App\Http\Livewire\Admin\User\CreateUser;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateUserTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_create_user()
    {
        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        Livewire::test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'John Doe')
            ->set('createForm.email', 'john@example.com')
            ->set('createForm.email_confirmation', 'john@example.com')
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password') // Agregar confirmación
            ->set('createForm.role', $studentRole->id)
            ->call('save');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
    /** @test */
    public function TestUserNameIsRequired()
    {


        Livewire::test(CreateUser::class)
        ->set('createForm.open', true)
        ->set('createForm.email', 'john@mail.com')
        ->set('createForm.password', 'password')
        ->set('createForm.role', 1)
        ->call('save')

            ->assertHasErrors(['createForm.name' => 'required']);

        $this->assertDatabaseCount('users', 0);
    }

      /** @test */
      public function TestEmailIsRequired()
      {


          Livewire::test(CreateUser::class)
          ->set('createForm.open', true)
          ->set('createForm.name', 'john')
          ->set('createForm.password', 'password')
          ->set('createForm.role', 1)
          ->call('save')

              ->assertHasErrors(['createForm.email' => 'required']);

          $this->assertDatabaseCount('users', 0);
      }

         /** @test */
         public function TestPasswordIsRequired()
         {


             Livewire::test(CreateUser::class)
             ->set('createForm.open', true)
             ->set('createForm.name', 'john')
             ->set('createForm.email', 'john@mail.com')
             ->set('createForm.role', 1)
             ->call('save')

                 ->assertHasErrors(['createForm.password' => 'required']);

             $this->assertDatabaseCount('users', 0);
         }


         /** @test */
         public function TestRoleIsRequired()
         {


             Livewire::test(CreateUser::class)
             ->set('createForm.open', true)
             ->set('createForm.name', 'john')
             ->set('createForm.email', 'john@mail.com')
             ->set('createForm.password', 'password')
             ->call('save')

                 ->assertHasErrors(['createForm.role' => 'required']);

             $this->assertDatabaseCount('users', 0);
         }

           /** @test */
         public function TestEmailIsACorrectForm()
         {


             Livewire::test(CreateUser::class)
             ->set('createForm.open', true)
             ->set('createForm.name', 'john')
             ->set('createForm.email', 'johnmail.com')
             ->set('createForm.password', 'password')
             ->set('createForm.role', '1')
             ->call('save')

                 ->assertHasErrors(['createForm.email']);

             $this->assertDatabaseCount('users', 0);
         }


           /** @test */
           public function TestPasswordNotReachTheLimitCharacter()
           {


               Livewire::test(CreateUser::class)
               ->set('createForm.open', true)
               ->set('createForm.name', 'john')
               ->set('createForm.email', 'johnmail.com')
               ->set('createForm.password', 'pass')
               ->set('createForm.role', '1')
               ->call('save')

                   ->assertHasErrors(['createForm.password']);

               $this->assertDatabaseCount('users', 0);
           }


            /** @test */
            public function TestTheIdRoleDoesNotExist()
            {


                Livewire::test(CreateUser::class)
                ->set('createForm.open', true)
                ->set('createForm.name', 'john')
                ->set('createForm.email', 'johnmail.com')
                ->set('createForm.password', 'pass')
                ->set('createForm.role', '5')
                ->call('save')

                    ->assertHasErrors(['createForm.role']);

                $this->assertDatabaseCount('users', 0);
            }


    /** @test */
    public function the_email_must_be_unique_creating_a_user()
    {
        $adminUser = $this->createAdmin();

        $existingUser = User::create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $existingUser->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'john')
            ->set('createForm.email', $existingUser->email)
            ->set('createForm.email_confirmation', $existingUser->email)
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $studentRole->id)
            ->call('save')
            ->assertHasErrors(['createForm.email' => 'unique']);

        $this->assertDatabaseCount('users', 2);//el $adminUser y $existingUser
    }


    /** @test */
    public function the_email_must_not_exceed_maximum_length_creating_a_user()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $longEmail = str_repeat('a', 46) . '@mail.com'; // Correo electrónico de más de 45 caracteres

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'john')
            ->set('createForm.email', $longEmail)
            ->set('createForm.email_confirmation', $longEmail)
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $studentRole->id)
            ->call('save')
            ->assertHasErrors(['createForm.email' => 'max']);

        $this->assertDatabaseCount('users', 1); // Solo el administrador
    }

    /** @test */
    public function the_password_must_not_exceed_maximum_length_creating_a_user()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $longPassword = str_repeat('a', 501); // Contraseña de más de 500 caracteres

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'john')
            ->set('createForm.email', 'john@mail.com')
            ->set('createForm.email_confirmation', 'john@mail.com')
            ->set('createForm.password', $longPassword)
            ->set('createForm.password_confirmation', $longPassword)
            ->set('createForm.role', $studentRole->id)
            ->call('save')
            ->assertHasErrors(['createForm.password' => 'max']);

        $this->assertDatabaseCount('users', 1); // Solo el administrador
    }

    /** @test */
    public function the_role_must_exist_creating_a_user()
    {
        $adminUser = $this->createAdmin();

        $invalidRoleId = 999; // Suponiendo que este ID no existe en la base de datos

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'john')
            ->set('createForm.email', 'john@mail.com')
            ->set('createForm.email_confirmation', 'john@mail.com')
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $invalidRoleId)
            ->call('save')
            ->assertHasErrors(['createForm.role' => 'exists']);

        $this->assertDatabaseCount('users', 1); // Solo el administrador
    }

    /** @test */
    public function the_password_must_meet_minimum_length_creating_a_user()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $shortPassword = 'short'; // Contraseña muy corta

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'john')
            ->set('createForm.email', 'john@mail.com')
            ->set('createForm.email_confirmation', 'john@mail.com')
            ->set('createForm.password', $shortPassword)
            ->set('createForm.password_confirmation', $shortPassword)
            ->set('createForm.role', $studentRole->id)
            ->call('save')
            ->assertHasErrors(['createForm.password' => 'min']);

        $this->assertDatabaseCount('users', 1); // Solo el administrador
    }

    /** @test */
    public function can_create_user_without_avatar()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'John Doe')
            ->set('createForm.email', 'john@example.com')
            ->set('createForm.email_confirmation', 'john@example.com')
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $studentRole->id)
            ->call('save');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function the_avatar_must_be_an_image()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $invalidAvatar = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'John Doe')
            ->set('createForm.email', 'john@example.com')
            ->set('createForm.email_confirmation', 'john@example.com')
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $studentRole->id)
            ->set('createForm.avatar', $invalidAvatar)
            ->call('save')
            ->assertHasErrors(['createForm.avatar' => 'image']);

        $this->assertDatabaseCount('users', 1); // Solo el administrador
    }

    /** @test */
    public function the_avatar_must_not_exceed_maximum_size()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $largeAvatar = UploadedFile::fake()->create('large-avatar.jpg')->size(2048); // 2MB file

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'John Doe')
            ->set('createForm.email', 'john@example.com')
            ->set('createForm.email_confirmation', 'john@example.com')
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $studentRole->id)
            ->set('createForm.avatar', $largeAvatar)
            ->call('save')
            ->assertHasErrors(['createForm.avatar' => 'max']);

        $this->assertDatabaseCount('users', 1); // Solo el administrador
    }

    /** @test */
    public function can_create_user_with_valid_avatar()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $validAvatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(512); // 512KB file

        Livewire::actingAs($adminUser)
            ->test(CreateUser::class)
            ->set('createForm.open', true)
            ->set('createForm.name', 'John Doe')
            ->set('createForm.email', 'john@example.com')
            ->set('createForm.email_confirmation', 'john@example.com')
            ->set('createForm.password', 'password')
            ->set('createForm.password_confirmation', 'password')
            ->set('createForm.role', $studentRole->id)
            ->set('createForm.avatar', $validAvatar)
            ->call('save');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

}
