<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase; // Limpia la BD en cada prueba

    /** @test */
    public function se_puede_crear_un_cliente_correctamente()
    {
        $user = User::factory()->create(); // Crear usuario
        $this->actingAs($user); // Autenticarse como ese usuario

        $datos = [
            'dni' => '12345678',
            'nombre' => 'Juan Pérez',
            'direccion' => 'Av. Siempre Viva 123',
            'telefono' => '987654321',
            'correo' => 'juan@example.com',
            'tipo_contrato' => 'con medidor',
        ];

        $response = $this->postJson(route('clientes.store'), $datos);

        // Verificar que se creó correctamente en la BD
        $this->assertDatabaseHas('clientes', ['dni' => '12345678']);

        // Laravel a veces redirige después de crear, revisa si devuelve 201 o 302
        $response->assertRedirect(route('clientes.index')); // Aceptar 302
    }

    /** @test */
    public function no_se_puede_crear_un_cliente_sin_dni()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $datos = [
            'nombre' => 'Carlos López',
            'direccion' => 'Jr. Los Cedros 456',
            'telefono' => '923456789',
            'correo' => 'carlos@example.com',
            'tipo_contrato' => 'sin medidor',
        ];

        $response = $this->postJson(route('clientes.store'), $datos);

        // Verificar que la respuesta tiene errores en el campo dni
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['dni']);
    }

    /** @test */
    public function se_puede_eliminar_un_cliente()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $cliente = Cliente::factory()->create();

        $response = $this->deleteJson(route('clientes.destroy', $cliente));

        // Verificar que el cliente ya no existe
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);

        // Laravel suele devolver 204 en eliminaciones
        $response->assertRedirect(route('clientes.index')); // Aceptar 302
    }
}
