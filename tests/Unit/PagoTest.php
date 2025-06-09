<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_un_pago_correctamente()
    {
        $factura = Factura::factory()->create();
        
        $pago = Pago::create([
            'factura_id' => $factura->id,
            'monto_pagado' => 100.50,
            'fecha_pago' => now()->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('pagos', [
            'factura_id' => $factura->id,
            'monto_pagado' => 100.50,
        ]);
    }

    /** @test */
    public function no_puede_crear_pago_con_datos_invalidos()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Pago::create([
            'factura_id' => null,
            'monto_pagado' => -50, // Valor inválido
            'fecha_pago' => 'fecha_invalida',
        ]);
    }

    /** @test */
    public function puede_actualizar_un_pago()
    {
        $pago = Pago::factory()->create();

        $pago->update(['monto_pagado' => 200.00]);

        $this->assertDatabaseHas('pagos', [
            'id' => $pago->id,
            'monto_pagado' => 200.00,
        ]);
    }

    /** @test */
    public function puede_eliminar_un_pago()
    {
        $pago = Pago::factory()->create();
        $pago->delete();

        $this->assertDatabaseMissing('pagos', ['id' => $pago->id]);
    }

    /** @test */
    public function un_pago_esta_asociado_a_una_factura()
    {
        $factura = Factura::factory()->create();
        $pago = Pago::factory()->create(['factura_id' => $factura->id]);

        $this->assertEquals($factura->id, $pago->factura->id);
    }

    /** @test */
    public function puede_generar_pdf_de_pago()
    {
        $pago = Pago::factory()->create();

        $pdf = Pdf::loadView('pagos.pdf', ['pago' => $pago]);

        $this->assertNotEmpty($pdf->output());
    }
}
