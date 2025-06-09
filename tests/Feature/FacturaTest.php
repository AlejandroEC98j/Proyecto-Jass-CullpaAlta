<?php

namespace Tests\Feature;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacturaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_una_factura_correctamente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->postJson('/facturas', [
            'cliente_id' => $cliente->id,
            'numero_factura' => '12345',
            'monto_total' => 150.50,
            'estado' => 'pendiente',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('facturas', ['numero_factura' => '12345']);
    }

    /** @test */
    public function no_puede_crear_una_factura_sin_cliente()
    {
        // Crear un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Enviar la solicitud sin un cliente_id
        $response = $this->postJson('/facturas', [
            'numero_factura' => '67890',
            'monto_total' => 100.50,
            'estado' => 'pendiente',
            'fecha_emision' => now()->toDateString(),
            'fecha_vencimiento' => now()->addDays(30)->toDateString(),
        ]);

        // Verificar que el estado HTTP sea 422 (error de validación)
        $response->assertStatus(422);

        // Asegurar que la factura no se haya guardado en la base de datos
        $this->assertDatabaseMissing('facturas', ['numero_factura' => '67890']);
    }

    /** @test */
    public function puede_eliminar_una_factura()
    {
        // Autenticar usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear una factura
        $factura = Factura::factory()->create();

        // Enviar solicitud DELETE como JSON
        $response = $this->deleteJson("/facturas/{$factura->id}");

        // Verificar que la respuesta sea 200
        $response->assertStatus(200);

        // Confirmar que la factura fue eliminada
        $this->assertDatabaseMissing('facturas', ['id' => $factura->id]);
    }
}
