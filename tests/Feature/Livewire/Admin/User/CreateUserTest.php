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



}
