<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Factura;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CajaBlancaFacturaTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test para almacenar una nueva factura.
     */
    public function test_store_creates_new_factura_and_redirects()
    {
        // Creamos un cliente de prueba
        $cliente = Cliente::factory()->create();

        $facturaData = [
            'cliente_id'      => $cliente->id,
            'numero_factura'  => 'FAC-1001',
            'monto_total'     => 150.75,
            'estado'          => 'pendiente',
        ];

        $response = $this->post(route('facturas.store'), $facturaData);

        $response->assertRedirect(route('facturas.index'));
        $this->assertDatabaseHas('facturas', [
            'numero_factura' => 'FAC-1001',
            'estado'         => 'pendiente',
        ]);

        // Verificamos que se hayan asignado las fechas correctamente.
        $factura = Factura::where('numero_factura', 'FAC-1001')->first();
        $this->assertNotNull($factura->fecha_emision);
        // La diferencia entre fecha_vencimiento y fecha_emision debe ser de 45 días.
        $diferencia = Carbon::parse($factura->fecha_vencimiento)->diffInDays($factura->fecha_emision);
        $this->assertEquals(45, $diferencia);
    }
    
    /**
     * Test para actualizar una factura existente.
     */
    public function test_update_modifies_factura_and_redirects()
    {
        $cliente = Cliente::factory()->create();
        $factura = Factura::factory()->create([
            'cliente_id'     => $cliente->id,
            'numero_factura' => 'FAC-3003',
            'monto_total'    => 200,
            'estado'         => 'pendiente'
        ]);

        $updateData = [
            'cliente_id'     => $cliente->id,
            'numero_factura' => 'FAC-3003',  // mismo número
            'monto_total'    => 250.50,
            'estado'         => 'pagado'
        ];

        $response = $this->put(route('facturas.update', $factura), $updateData);

        $response->assertRedirect(route('facturas.index'));
        $this->assertDatabaseHas('facturas', [
            'id'             => $factura->id,
            'monto_total'    => 250.50,
            'estado'         => 'pagado'
        ]);
    }

    /**
     * Test para eliminar una factura.
     */
    public function test_destroy_deletes_factura_and_redirects()
    {
        $factura = Factura::factory()->create([
            'numero_factura' => 'FAC-4004',
            'estado'         => 'pendiente'
        ]);

        $response = $this->delete(route('facturas.destroy', $factura));

        $response->assertRedirect(route('facturas.index'));
        $this->assertDatabaseMissing('facturas', ['id' => $factura->id]);
    }
    
}
