<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PruebaRegresionBaseDatosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_estructura_tablas_mysql()
    {
        // Verificar que las tablas existen
        $tablas = ['clientes', 'medidores', 'facturas', 'pagos', 'lecturas_medidor'];

        foreach ($tablas as $tabla) {
            $this->assertTrue(
                Schema::hasTable($tabla),
                "La tabla {$tabla} no existe en la base de datos."
            );
        }

        // Verificar columnas clave en la tabla clientes
        $this->verificarColumnas('clientes', ['nombre', 'direccion', 'telefono', 'tipo_contrato']);

        // Verificar columnas clave en la tabla medidores
        $this->verificarColumnas('medidores', ['numero_serie', 'cliente_id']);

        // Verificar columnas clave en la tabla facturas
        $this->verificarColumnas('facturas', ['cliente_id', 'monto_total', 'fecha_emision']);

        // Verificar columnas clave en la tabla pagos
        $this->verificarColumnas('pagos', ['factura_id', 'monto_pagado', 'fecha_pago']);
    }

    
    private function verificarColumnas(string $tabla, array $columnas)
    {
        foreach ($columnas as $columna) {
            $this->assertTrue(
                Schema::hasColumn($tabla, $columna),
                "La columna {$columna} no existe en la tabla {$tabla}."
            );
        }
    }
}
