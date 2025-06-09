<?php

namespace Tests\Unit;

use App\Models\Cliente;
use App\Models\Medidor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase; // Limpia la base de datos después de cada prueba

    /** @test */
    public function se_puede_crear_un_cliente()
    {
        $cliente = Cliente::factory()->create([
            'dni' => '12345678',
            'nombre' => 'Juan Pérez',
            'direccion' => 'Av. Siempre Viva 123',
            'tipo_contrato' => 'con medidor'
        ]);

        $this->assertDatabaseHas('clientes', ['dni' => '12345678']);
    }

    /** @test */
    public function dni_nombre_direccion_y_tipo_contrato_son_obligatorios()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Cliente::create([]); // Intenta crear un cliente sin datos
    }
}
