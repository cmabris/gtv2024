<?php

namespace Tests\Feature\Livewire\Map;

use App\Http\Livewire\Admin\Point\CreatePoint;
use App\Models\Place;
use App\Models\PointOfInterest;
use Database\Factories\PointOfInterestFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MapTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testMapPage()
    {
        // Crea un usuario administrador para la autenticación
        $adminUser = $this->createAdmin();

        // Autentica como el usuario administrador
        $this->actingAs($adminUser);

        // Realiza una solicitud GET a la página del mapa
        $response = $this->get('/map');

        // Asegura que la respuesta tenga un código de estado 200 (OK)
        $response->assertStatus(200);

    }
    /** @test */
    public function testPointIsCreatedAndVisibleOnMap()
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
        $response = $this->get('/map');

        // Verificar que la página cargue correctamente
        $response->assertStatus(200);

        // Verificar que el marcador del punto de interés creado esté presente en el HTML generado por la página
        $response->assertSee($point->latitude);
        $response->assertSee($point->longitude);
        $response->assertSee($point->name);
    }


}

