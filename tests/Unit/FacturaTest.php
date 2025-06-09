<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class FacturaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function se_puede_crear_una_factura_valida()
    {
        $cliente = Cliente::factory()->create();

        $factura = Factura::create([
            'cliente_id' => $cliente->id,
            'numero_factura' => 'FAC-1001',
            'monto_total' => 150.75,
            'estado' => 'pendiente',
            'fecha_emision' => Carbon::now(),
            'fecha_vencimiento' => Carbon::now()->addDays(45),
        ]);

        $this->assertDatabaseHas('facturas', ['numero_factura' => 'FAC-1001']);
    }

    /** @test */
    public function una_factura_tiene_un_cliente_asociado()
    {
        $cliente = Cliente::factory()->create();
        $factura = Factura::factory()->create([
            'cliente_id' => $cliente->id,
            'numero_factura' => 'FAC-12345', // Asegurar número de factura
        ]);

        $this->assertEquals($cliente->id, $factura->cliente_id);
    }

    /** @test */
    public function verifica_fechas_de_factura()
    {
        $factura = Factura::factory()->create();

        $this->assertInstanceOf(Carbon::class, $factura->fecha_emision);
        $this->assertInstanceOf(Carbon::class, $factura->fecha_vencimiento);
    }
}
