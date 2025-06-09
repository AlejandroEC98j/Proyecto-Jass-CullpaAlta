<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Medidor;
use App\Models\Factura;
use App\Models\Pago;

class PagoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_pago_puede_ser_realizado_para_una_factura()
    {
        $factura = Factura::factory()->create();
        $pago = Pago::factory()->create(['factura_id' => $factura->id]);

        $this->assertDatabaseHas('pagos', [
            'factura_id' => $factura->id,
            'monto_pagado' => $pago->monto_pagado
        ]);
    }

    /** @test */
    public function un_pago_puede_ser_creado_mediante_una_solicitud_http()
    {
        $this->withoutExceptionHandling(); // Opcional, para ver más detalles si hay errores

        // Crear un usuario y autenticarlo
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user); 

        $factura = Factura::factory()->create();
        
        $data = [
            'factura_id' => $factura->id,
            'monto_pagado' => 100.50,
            'fecha_pago' => now()->toDateString(),
        ];

        $response = $this->post(route('pagos.store'), $data);

        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseHas('pagos', $data);
    }

    /** @test */
    public function una_factura_se_marca_como_pagada_al_registrar_un_pago()
    {
        $this->withoutExceptionHandling();

        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Crear una factura con estado inicial "pendiente"
        $factura = Factura::factory()->create(['estado' => 'pendiente']);

        $data = [
            'factura_id' => $factura->id,
            'monto_pagado' => 100.50,
            'fecha_pago' => now()->toDateString(),
        ];

        $this->post(route('pagos.store'), $data);

        // Recargar la factura desde la base de datos para asegurar la actualización
        $factura->refresh();

        // Verificar que la factura ahora tiene estado "pagado"
        $this->assertEquals('pagado', $factura->estado);
    }

    /** @test */
    public function un_pago_puede_ser_eliminado()
    {
        $this->withoutExceptionHandling(); // Para ver errores detallados en la prueba

        // Crear y autenticar un usuario
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Crear un pago
        $pago = Pago::factory()->create();

        // Enviar la solicitud DELETE
        $response = $this->delete(route('pagos.destroy', $pago->id));

        // Asegurar que se redirige correctamente
        $response->assertRedirect(route('pagos.index'));

        // Verificar que el pago ya no está en la base de datos
        $this->assertDatabaseMissing('pagos', ['id' => $pago->id]);
    }

}