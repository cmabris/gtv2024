<?php

namespace Tests\Feature\Livewire\Admin\User;

use App\Http\Livewire\Admin\User\ListUsers;
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
        $teacherRole = Role::create(['name' => 'Profesor']);

        $user1 = $this->createStudent();
        $user2 = $this->createStudent();

        $user2->assignRole($teacherRole);

        $this->assertDatabaseCount('users',3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('show', $user1)
            ->assertSee($user1->name)
            ->assertSee($user1->email)
            ->assertSee($user1->roles->first()->name)
            ->assertSee($user1->created_at->toDateString())
            ->assertSee($user1->updated_at->toDateString())
            ->call('show', $user2)
            ->assertSee($user2->name)
            ->assertSee($user2->email)
            ->assertSee($user2->roles->first()->name)
            ->assertSee($user2->created_at->toDateString())
            ->assertSee($user2->updated_at->toDateString());
    }

    //BUSCAR
    /** @test */
    public function it_searches_users_by_id()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent();
        $user3 = $this->createStudent();

        $this->assertDatabaseCount('users',4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'id')
            ->set('search', $user2->id)
            ->call('render')
            ->assertSee($user2->email)
            ->assertDontSee($user1->email)
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_searches_users_by_name()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent(['name'=>'Paco']);
        $user3 = $this->createStudent(['name'=>'Alfonso']);

        $this->assertDatabaseCount('users',4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'paco')
            ->call('render')
            ->assertSee($user2->email)
            ->assertDontSee($user1->email)
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_searches_users_by_created_at()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['created_at' => now()->subDays(2)]);
        $user2 = $this->createStudent(['created_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['created_at' => now()]);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'created_at')
            ->set('search', $user1->created_at->toDateString())
            ->call('render')
            ->assertSee($user1->email)
            ->assertDontSee($user2->email)
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_searches_users_by_updated_at()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['updated_at' => now()->subDays(2)]);
        $user2 = $this->createStudent(['updated_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['updated_at' => now()]);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'updated_at')
            ->set('search', $user1->updated_at->toDateString())
            ->call('render')
            ->assertSee($user1->email)
            ->assertDontSee($user2->email)
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_resets_filters()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent(['name'=>'Paco', 'updated_at' => now()]);
        $user3 = $this->createStudent();

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'paco')
            ->assertSee($user2->email)
            ->assertDontSee($user1->email)
            ->assertDontSee($user3->email)
            ->call('resetFilters')
            ->call('render')
            ->assertSee($user1->email)
            ->assertSee($user2->email)
            ->assertSee($user3->email);
    }

    //ORDENACIÓN
    /** @test */
    public function it_sorts_users_by_id_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent();
        $user3 = $this->createStudent();

        $this->assertDatabaseCount('users',4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'id')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user2->email, $user3->email]);
    }

    /** @test */
    public function it_sorts_users_by_id_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent();
        $user3 = $this->createStudent();

        $this->assertDatabaseCount('users',4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'id')
            ->call('sort', 'id')
            ->call('render')
            ->assertSeeInOrder([$user3->email, $user2->email, $user1->email]);
    }

    /** @test */
    public function it_sorts_users_by_name_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent(['name'=>'Alfonso']);
        $user3 = $this->createStudent(['name'=>'Bartolo']);

        $this->assertDatabaseCount('users',4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user2->name, $user3->name, $user1->name]);
    }
    /** @test */
    public function it_sorts_users_by_name_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent(['name'=>'Alfonso']);
        $user3 = $this->createStudent(['name'=>'Bartolo']);

        $this->assertDatabaseCount('users',4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'name')
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user1->name, $user3->name, $user2->name]);
    }

    /** @test */
    public function it_sorts_users_by_email_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent(['email' => 'a_student@mail.com']);
        $user3 = $this->createStudent(['email' => 'b_student@mail.com']);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user2->email, $user3->email, $user1->email]);
    }
    /** @test */
    public function it_sorts_users_by_email_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent();
        $user2 = $this->createStudent(['email' => 'a_student@mail.com']);
        $user3 = $this->createStudent(['email' => 'b_student@mail.com']);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'email')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user3->email, $user2->email]);
    }
    /** @test */
    public function it_sorts_users_by_created_at_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['created_at' => now()->subDays(2)]);
        $user2 = $this->createStudent(['created_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['created_at' => now()]);

        $this->assertDatabaseCount('users', 4); // 3 students + 1 admin

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'created_at')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user2->email, $user3->email]);
    }

    /** @test */
    public function it_sorts_users_by_created_at_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['created_at' => now()->subDays(2)]);
        $user2 = $this->createStudent(['created_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['created_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'created_at')
            ->call('sort', 'created_at')
            ->call('render')
            ->assertSeeInOrder([$user3->email, $user2->email, $user1->email]);
    }
    /** @test */
    public function it_sorts_users_by_updated_at_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['updated_at' => now()->subDays(2)]);
        $user2 = $this->createStudent(['updated_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['updated_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'updated_at')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user2->email, $user3->email]);
    }

    /** @test */
    public function it_sorts_users_by_updated_at_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['updated_at' => now()->subDays(2)]);
        $user2 = $this->createStudent(['updated_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['updated_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'updated_at')
            ->call('sort', 'updated_at')
            ->call('render')
            ->assertSeeInOrder([$user3->email, $user2->email, $user1->email]);
    }
    //FILTROS COMPUESTOS
    /** @test */
    public function it_searches_users_by_name_and_sorts_by_email_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['name' => 'Paco', 'email' => 'b_student@mail.com']);
        $user2 = $this->createStudent(['name' => 'Pablo', 'email' => 'a_student@mail.com']);
        $user3 = $this->createStudent();

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'Pa')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user2->email, $user1->email])
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_searches_users_by_name_and_sorts_by_email_desc()
    {
        $adminUser = $this->createAdmin();

        $user1 = $this->createStudent(['name' => 'Paco', 'email' => 'b_student@mail.com']);
        $user2 = $this->createStudent(['name' => 'Paco', 'email' => 'a_student@mail.com']);
        $user3 = $this->createStudent();

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'Paco')
            ->call('sort', 'email')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user2->email])
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_searches_users_by_created_at_and_sorts_by_name_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['name' => 'Alfonso', 'created_at' => now()->subDays(1)]);
        $user2 = $this->createStudent(['name' => 'Bartolo', 'created_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['created_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'created_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user1->name, $user2->name])
            ->assertDontSee($user3->name);
    }

    /** @test */
    public function it_searches_users_by_created_at_and_sorts_by_name_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['name' => 'Alfonso', 'created_at' => now()->subDays(1)]);
        $user2 = $this->createStudent(['name' => 'Bartolo', 'created_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['created_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'created_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'name')
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user2->name, $user1->name])
            ->assertDontSee($user3->name);
    }

    /** @test */
    public function it_searches_users_by_updated_at_and_sorts_by_email_asc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['email'=>'b_student@mail.com', 'updated_at' => now()->subDays(1)]);
        $user2 = $this->createStudent(['email'=>'a_student@mail.com', 'updated_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['updated_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'updated_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user2->email, $user1->email])
            ->assertDontSee($user3->email);
    }

    /** @test */
    public function it_searches_users_by_updated_at_and_sorts_by_email_desc()
    {
        $adminUser = $this->createAdmin();
        $user1 = $this->createStudent(['email'=>'b_student@mail.com', 'updated_at' => now()->subDays(1)]);
        $user2 = $this->createStudent(['email'=>'a_student@mail.com', 'updated_at' => now()->subDays(1)]);
        $user3 = $this->createStudent(['updated_at' => now()]);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'updated_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'email')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user2->email])
            ->assertDontSee($user3->email);
    }

}
