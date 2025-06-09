<?php

namespace Tests\Feature;

use App\Models\Pago;
use App\Models\Factura;
use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CajaBlancaPagoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void{
    parent::setUp();

    // Crear un usuario para autenticar las peticiones
    $this->user = User::factory()->create();

    // Registrar la ruta para generar PDF de forma incondicional
    \Illuminate\Support\Facades\Route::get('/pagos/{id}/pdf', [\App\Http\Controllers\PagoController::class, 'generarPDF'])
        ->name('pagos.generarPDF');
    }


    /**
     * Verifica que el método index muestre la vista con la lista de pagos.
     */
    public function test_index_displays_pagos()
    {
        $factura = Factura::factory()->create();
        $pago = Pago::factory()->create(['factura_id' => $factura->id]);

        $response = $this->actingAs($this->user)->get(route('pagos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pagos.index');
        $response->assertViewHas('pagos', function ($pagos) use ($pago) {
            return $pagos->contains($pago);
        });
    }

    /**
     * Verifica que la vista de creación muestre la factura correspondiente.
     */
    public function test_create_displays_factura()
    {
        $factura = Factura::factory()->create();

        $response = $this->actingAs($this->user)->get(route('pagos.create', $factura->id));

        $response->assertStatus(200);
        $response->assertViewIs('pagos.create');
        $response->assertViewHas('factura', function ($viewFactura) use ($factura) {
            return $viewFactura->id === $factura->id;
        });
    }

    /**
     * Verifica que se pueda almacenar un pago y que la factura asociada se marque como pagada.
     */
    public function test_store_creates_pago_and_updates_factura()
    {
        $factura = Factura::factory()->create(['estado' => 'pendiente']);
        $data = [
            'factura_id'   => $factura->id,
            'monto_pagado' => 100.50,
            'fecha_pago'   => Carbon::now()->toDateString(),
        ];

        $response = $this->actingAs($this->user)->post(route('pagos.store'), $data);

        // Ahora se espera redirección a pagos.index y no a login.
        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseHas('pagos', [
            'factura_id'   => $factura->id,
            'monto_pagado' => 100.50,
        ]);
        $this->assertDatabaseHas('facturas', [
            'id'     => $factura->id,
            'estado' => 'pagado'
        ]);
    }

    /**
     * Verifica que se pueda actualizar un pago existente.
     */
    public function test_update_modifies_pago()
    {
        $factura = Factura::factory()->create();
        $pago = Pago::factory()->create([
            'factura_id'   => $factura->id,
            'monto_pagado' => 50,
            'fecha_pago'   => Carbon::now()->subDay()->toDateString(),
        ]);

        $updateData = [
            'monto_pagado' => 75,
            'fecha_pago'   => Carbon::now()->toDateString(),
        ];

        $response = $this->actingAs($this->user)->put(route('pagos.update', $pago->id), $updateData);

        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseHas('pagos', [
            'id'           => $pago->id,
            'monto_pagado' => 75,
        ]);
    }

    /**
     * Verifica que se pueda eliminar un pago.
     */
    public function test_destroy_deletes_pago()
    {
        $factura = Factura::factory()->create();
        $pago = Pago::factory()->create(['factura_id' => $factura->id]);

        $response = $this->actingAs($this->user)->delete(route('pagos.destroy', $pago->id));

        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseMissing('pagos', ['id' => $pago->id]);
    }
}
