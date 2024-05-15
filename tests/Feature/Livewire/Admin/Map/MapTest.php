<?php

namespace Tests\Feature\Livewire\Map;

use App\Http\Livewire\Admin\Point\CreatePoint;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
use Database\Factories\PointOfInterestFactory;
use Database\Seeders\PlaceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MapTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testMapPageWithGTVisor()
    {
        // Ejecuta el seeder para crear los usuarios, incluido GTVisor
        $this->seed(UserSeeder::class);

        // Encuentra el usuario GTVisor creado por el seeder
        $gtvisor = User::where('email', 'gtvisor@mail.com')->first();

        // Autentica como el usuario GTVisor
        $this->actingAs($gtvisor);

        // Realiza una solicitud GET a la página
        $response = $this->get('/');

        // Asegura que la respuesta tenga un código de estado 200 (OK)
        $response->assertStatus(200);
    }
    public function testGTVisorPointIsCreatedAndVisibleOnMap()
    {
        // Ejecutar el seeder para crear los usuarios y el lugar
        $this->seed(UserSeeder::class);
        $this->seed(PlaceSeeder::class);

        // Buscar el usuario GTVisor y el lugar creado por los seeders
        $gtvisor = User::where('email', 'gtvisor@mail.com')->first();
        $place = Place::first();

        // Autenticar como el usuario GTVisor
        $this->actingAs($gtvisor);

        // Asegurar que no hay puntos de interés en la base de datos inicialmente
        $this->assertDatabaseCount('point_of_interests', 0);

        // Simular la interacción del usuario con el componente Livewire para crear un nuevo punto de interés
        Livewire::test(CreatePoint::class)
            ->set('createForm.name', 'Prueba')
            ->set('createForm.distance', '99')
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save');

        // Verificar que se haya creado el punto de interés en la base de datos
        $this->assertDatabaseCount('point_of_interests', 1);

        // Obtener el último punto de interés creado en la base de datos
        $point = PointOfInterest::latest()->first();

        // Realizar una solicitud HTTP a la página del mapa
        $response = $this->get('/');

        // Verificar que la página cargue correctamente
        $response->assertStatus(200);

        // Verificar que el marcador del punto de interés creado esté presente en el HTML generado por la página
        $response->assertSee($point->latitude);
        $response->assertSee($point->longitude);
        $response->assertSee($point->name);
    }


    /** @test */
    public function testAdminPointIsCreatedAndVisibleOnMap()
    {
        // Crear un usuario administrador y un lugar
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();

        // Actuar como el usuario administrador
        $this->actingAs($adminUser);

        // Asegurar que no hay puntos de interés en la base de datos inicialmente
        $this->assertDatabaseCount('point_of_interests', 0);

        // Simular la interacción del usuario con el componente Livewire para crear un nuevo punto de interés
        Livewire::test(CreatePoint::class)
            ->set('createForm.name', 'Prueba')
            ->set('createForm.distance', '99')
            ->set('createForm.latitude', '10')
            ->set('createForm.longitude', '15')
            ->set('createForm.place', $place->id)
            ->call('save');

        // Verificar que se haya creado el punto de interés en la base de datos
        $this->assertDatabaseCount('point_of_interests', 1);

        // Obtener el último punto de interés creado en la base de datos
        $point = PointOfInterest::latest()->first();

        // Realizar una solicitud HTTP a la página del mapa
        $response = $this->get('/');

        // Verificar que la página cargue correctamente
        $response->assertStatus(200);

        // Verificar que el marcador del punto de interés creado esté presente en el HTML generado por la página
        $response->assertSee($point->latitude);
        $response->assertSee($point->longitude);
        $response->assertSee($point->name);
    }


}

