<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Medidor;
use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CajaBlancaDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica que los usuarios no autenticados sean redirigidos al login.
     */
    public function test_dashboard_redirects_for_guest_users()
    {
        $response = $this->get(route('dashboard'));

        // Se espera una redirección (por ejemplo, a '/login') si el usuario no está autenticado
        $response->assertRedirect('/login');
    }
}
