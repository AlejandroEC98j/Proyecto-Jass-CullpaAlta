<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Medidor;
use App\Models\User;

class MedidorTest extends TestCase
{
    use RefreshDatabase, WithFaker; // Limpia la BD y genera datos aleatorios

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Crear usuario de prueba
    }

    /** @test */
    public function un_usuario_puede_crear_un_medidor()
    {
        $this->actingAs($this->user);

        $data = [
            'numero_serie' => $this->faker->unique()->numerify('#########'),
            'direccion' => $this->faker->address(),
            'estado' => 'Activo',
        ];

        $response = $this->post(route('medidores.store'), $data);
        $response->assertRedirect(route('medidores.index'));

        $this->assertDatabaseHas('medidores', $data);
    }

    /** @test */
    public function la_creacion_de_medidor_requiere_campos_obligatorios()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('medidores.store'), []);

        $response->assertSessionHasErrors(['numero_serie', 'direccion', 'estado']);
    }

    /** @test */
    public function no_se_puede_crear_un_medidor_con_estado_invalido()
    {
        $this->actingAs($this->user);

        $data = [
            'numero_serie' => $this->faker->unique()->numerify('#########'),
            'direccion' => $this->faker->address(),
            'estado' => 'EstadoIncorrecto', // Estado inválido
        ];

        $response = $this->post(route('medidores.store'), $data);
        $response->assertSessionHasErrors(['estado']);
    }
}
