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
        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $teacherRole = Role::create(['name' => 'Profesor']);

        $user = User::create([
            'name' => 'Student',
            'email' => 'student1@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user2 = User::create([
            'name' => 'Student',
            'email' => 'student2@mail.com',
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

    //BUSCAR
    /** @test */
    public function it_searches_users_by_id()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Paco',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users',3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'id')
            ->set('search', $user2->id)
            ->call('render')
            ->assertSee($user2->name)
            ->assertDontSee($user1->name);
    }

    /** @test */
    public function it_searches_users_by_name()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Paco',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users',3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'paco')
            ->call('render')
            ->assertSee($user2->name)
            ->assertDontSee($user1->name);
    }

    /** @test */
    public function it_searches_users_by_created_at()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'created_at' => now(),
            'name' => 'Paco',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'created_at')
            ->set('search', $user1->created_at->toDateString())
            ->call('render')
            ->assertSee($user1->name)
            ->assertDontSee($user2->name);
    }

    /** @test */
    public function it_searches_users_by_updated_at()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'updated_at' => now(),
            'name' => 'Paco',
            'email' => 'student2@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'updated_at')
            ->set('search', $user1->updated_at->toDateString())
            ->call('render')
            ->assertSee($user1->name)
            ->assertDontSee($user2->name);
    }

    /** @test */
    public function it_resets_filters()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'created_at' => now(),
            'name' => 'Paco',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'paco')
            ->assertSee($user2->name)
            ->assertDontSee($user1->name)
            ->call('resetFilters')
            ->call('render')
            ->assertSee($user1->name)
            ->assertSee($user2->name);
    }

    //ORDENACIÓN
    /** @test */
    public function it_sorts_users_by_id_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users',3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'id')
            ->call('render')
            ->assertSeeInOrder([$user1->name, $user2->name]);
    }

    /** @test */
    public function it_sorts_users_by_id_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users',3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'id')
            ->call('sort', 'id')
            ->call('render')
            ->assertSeeInOrder([$user2->name, $user1->name]);
    }

    /** @test */
    public function it_sorts_users_by_name()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Alfonso',
            'email' => 'student2@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users',3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user2->name, $user1->name]);

    }

    /** @test */
    public function it_sorts_users_by_email_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'b_student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Student',
            'email' => 'a_student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users', 3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user2->email, $user1->email]);
    }
    /** @test */
    public function it_sorts_users_by_email_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Student',
            'email' => 'b_student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Student',
            'email' => 'a_student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users', 3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'email')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user2->email]);
    }
    /** @test */
    public function it_sorts_users_by_created_at_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'created_at' => now(),
            'name' => 'Student',
            'email' => 'student2@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users', 3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'created_at')
            ->call('render')
            ->assertSeeInOrder([$user1->name, $user2->name]);
    }

    /** @test */
    public function it_sorts_users_by_created_at_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'created_at' => now(),
            'name' => 'Student',
            'email' => 'student2@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users', 3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'created_at')
            ->call('sort', 'created_at')
            ->call('render')
            ->assertSeeInOrder([$user2->name, $user1->name]);
    }
    /** @test */
    public function it_sorts_users_by_updated_at_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'updated_at' => now(),
            'name' => 'Student',
            'email' => 'student2@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users', 3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'updated_at')
            ->call('render')
            ->assertSeeInOrder([$user1->name, $user2->name]);
    }

    /** @test */
    public function it_sorts_users_by_updated_at_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'updated_at' => now(),
            'name' => 'Student',
            'email' => 'student2@mail.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $this->assertDatabaseCount('users', 3);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->call('sort', 'updated_at')
            ->call('sort', 'updated_at')
            ->call('render')
            ->assertSeeInOrder([$user2->name, $user1->name]);
    }
    //FILTROS COMPUESTOS
    /** @test */
    public function it_searches_users_by_name_and_sorts_by_email_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Paco',
            'email' => 'paco@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Pablo',
            'email' => 'pablo@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $user3 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole($studentRole);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'Pa')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user2->email, $user1->email])
            ->assertDontSee($user3->name);
    }

    /** @test */
    public function it_searches_users_by_name_and_sorts_by_email_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'name' => 'Paco',
            'email' => 'paco1@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'name' => 'Paco',
            'email' => 'paco2@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $user3 = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole($studentRole);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'name')
            ->set('search', 'Paco')
            ->call('sort', 'email')
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user2->email, $user1->email])
            ->assertDontSee($user3->name);
    }

    /** @test */
    public function it_searches_users_by_created_at_and_sorts_by_name_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'created_at' => now(),
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $user3 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Charlie',
            'email' => 'charlie@example.com',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole($studentRole);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'created_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user1->name, $user3->name])
            ->assertDontSee($user2->name);
    }

    /** @test */
    public function it_searches_users_by_created_at_and_sorts_by_name_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'created_at' => now(),
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $user3 = User::factory()->create([
            'created_at' => now()->subDays(1),
            'name' => 'Charlie',
            'email' => 'charlie@example.com',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole($studentRole);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'created_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'name')
            ->call('sort', 'name')
            ->call('render')
            ->assertSeeInOrder([$user3->name, $user1->name])
            ->assertDontSee($user2->name);
    }

    /** @test */
    public function it_searches_users_by_updated_at_and_sorts_by_email_asc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student One',
            'email' => 'one@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'updated_at' => now(),
            'name' => 'Student Two',
            'email' => 'two@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $user3 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student Three',
            'email' => 'three@example.com',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole($studentRole);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'updated_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'email')
            ->call('render')
            ->assertSeeInOrder([$user1->email, $user3->email])
            ->assertDontSee($user2->name);
    }

    /** @test */
    public function it_searches_users_by_updated_at_and_sorts_by_email_desc()
    {
        $adminUser = $this->createAdmin();

        $studentRole = Role::create(['name' => 'Alumno']);

        $user1 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student One',
            'email' => 'one@example.com',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($studentRole);

        $user2 = User::factory()->create([
            'updated_at' => now(),
            'name' => 'Student Two',
            'email' => 'two@example.com',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole($studentRole);

        $user3 = User::factory()->create([
            'updated_at' => now()->subDays(1),
            'name' => 'Student Three',
            'email' => 'three@example.com',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole($studentRole);

        $this->assertDatabaseCount('users', 4);

        Livewire::actingAs($adminUser)
            ->test(ListUsers::class)
            ->set('searchColumn', 'updated_at')
            ->set('search', now()->subDays(1)->toDateString())
            ->call('sort', 'email')
            ->call('sort', 'email') 
            ->call('render')
            ->assertSeeInOrder([$user3->email, $user1->email])
            ->assertDontSee($user2->name);
    }

}
