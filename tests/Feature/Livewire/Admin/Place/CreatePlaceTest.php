<?php

namespace Tests\Feature\Livewire\Admin\Place;

use App\Livewire\Admin\Places\CreatePlace;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePlaceTest extends TestCase
{
    public function testICanCreateAPlace()
    {
        $adminUser = $this->createAdmin();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('places', 0);

        Livewire::test(CreatePlace::class)
            ->set('createForm.name', 'name')
            ->set('createForm.description', 'Place description')
            ->call('save');

        $this->assertDatabaseCount('places', 1);

        $this->assertDatabaseHas('places', [
            'name' => 'name',
            'description' => 'Place description',
        ]);
    }

    /** @test */
    public function testListPlace()
    {
        $adminUser = $this->createAdmin();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('places', 0);

        Livewire::test(CreatePlace::class)
            ->set('createForm.name', 'name')
            ->set('createForm.description', 'Description')
            ->call('save');

        $this->assertDatabaseCount('places', 1);
        $response = $this->get('/places');

        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('Description');
    }
    public function testNameFieldIsRequiredWhenCreatingAPlace()
    {
        $adminUser = $this->createAdmin();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('places', 0);

        Livewire::test(CreatePlace::class)
            ->set('createForm.name', '')
            ->set('createForm.description', 'Place description')
            ->call('save')
            ->assertHasErrors(['createForm.name' => 'required']);

        $this->assertDatabaseCount('places', 0);
    }

    public function testDescriptionFieldIsRequiredWhenCreatingAPlace()
    {
        $adminUser = $this->createAdmin();

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('places', 0);

        Livewire::test(CreatePlace::class)
            ->set('createForm.name', 'name')
            ->set('createForm.description', '')
            ->call('save')
            ->assertHasErrors(['createForm.description' => 'required']);

        $this->assertDatabaseCount('places', 0);
    }
}
