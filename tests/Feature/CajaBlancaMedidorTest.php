<?php

namespace Tests\Feature;

use App\Models\Medidor;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CajaBlancaMedidorTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Se crea un usuario para simular la autenticación
        $this->user = User::factory()->create();
    }

    /**
     * Verifica que la vista create muestre el formulario con la lista de clientes.
     */
    public function test_create_displays_form_with_clientes()
    {
        // Crear clientes para poblar el select del formulario
        Cliente::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get(route('medidores.create'));

        $response->assertStatus(200);
        $response->assertViewIs('medidores.create');
        $response->assertViewHas('clientes');
    }

    /**
     * Verifica que se pueda almacenar un nuevo medidor y se redirija correctamente.
     */
    public function test_store_creates_medidor_and_redirects()
    {
        $cliente = Cliente::factory()->create();

        $data = [
            'cliente_id'    => $cliente->id,
            'numero_serie'  => 'MS-123456',
            'direccion'     => 'Calle Principal 123',
            'estado'        => 'Activo'
        ];

        $response = $this->actingAs($this->user)->post(route('medidores.store'), $data);

        $response->assertRedirect(route('medidores.index'));
        $this->assertDatabaseHas('medidores', [
            'numero_serie' => 'MS-123456',
            'estado'       => 'Activo'
        ]);
    }

    /**
     * Verifica que la vista edit muestre el medidor y la lista de clientes.
     */
    public function test_edit_displays_medidor_and_clientes()
    {
        $cliente = Cliente::factory()->create();
        $medidor = Medidor::factory()->create([
            'cliente_id'    => $cliente->id,
            'numero_serie'  => 'MS-7891011',
            'direccion'     => 'Calle Secundaria 456',
            'estado'        => 'Activo'
        ]);

        $response = $this->actingAs($this->user)->get(route('medidores.edit', $medidor));

        $response->assertStatus(200);
        $response->assertViewIs('medidores.edit');
        $response->assertViewHasAll(['medidor', 'clientes']);
    }

    /**
     * Verifica que se pueda actualizar un medidor y se redirija correctamente.
     */
    public function test_update_modifies_medidor_and_redirects()
    {
        $cliente = Cliente::factory()->create();
        $medidor = Medidor::factory()->create([
            'cliente_id'    => $cliente->id,
            'numero_serie'  => 'MS-555555',
            'direccion'     => 'Direccion inicial',
            'estado'        => 'Activo'
        ]);

        // Dado que en la regla de actualización se exige que el número de serie sea único,
        // se envía un nuevo número de serie para evitar conflictos.
        $updateData = [
            'cliente_id'    => $cliente->id,
            'numero_serie'  => 'MS-999999',
            'direccion'     => 'Direccion actualizada',
            'estado'        => 'Inactivo'
        ];

        $response = $this->actingAs($this->user)->put(route('medidores.update', $medidor), $updateData);

        $response->assertRedirect(route('medidores.index'));
        $this->assertDatabaseHas('medidores', [
            'id'            => $medidor->id,
            'numero_serie'  => 'MS-999999',
            'direccion'     => 'Direccion actualizada',
            'estado'        => 'Inactivo'
        ]);
    }

}
