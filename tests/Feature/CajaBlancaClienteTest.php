<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CajaBlancaClienteTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Crear un usuario para la autenticación
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_displays_the_clients_index_page()
    {
        Cliente::factory()->count(3)->create(); // Crear clientes de prueba

        $response = $this->actingAs($this->user)->get(route('clientes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('clientes.index');
        $response->assertViewHas('clientes');
    }

    /** @test */
    public function it_can_create_a_new_client()
    {
        $clientData = [
            'dni' => '12345678',
            'nombre' => 'Juan Pérez',
            'direccion' => 'Av. Principal 123',
            'telefono' => '987654321',
            'correo' => 'juan@example.com',
            'tipo_contrato' => 'con medidor',
        ];

        $response = $this->actingAs($this->user)->post(route('clientes.store'), $clientData);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', ['dni' => '12345678']);
    }

    /** @test */
    public function it_can_update_an_existing_client()
    {
        $cliente = Cliente::factory()->create(['dni' => '87654321']);

        $updateData = [
            'dni' => '87654321',
            'nombre' => 'Carlos López',
            'direccion' => 'Calle Nueva 456',
            'telefono' => '912345678',
            'correo' => 'carlos@example.com',
            'tipo_contrato' => 'sin medidor',
        ];

        $response = $this->actingAs($this->user)->put(route('clientes.update', $cliente), $updateData);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', ['nombre' => 'Carlos López']);
    }

    /** @test */
    public function it_can_delete_a_client()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('clientes.destroy', $cliente));

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

}
