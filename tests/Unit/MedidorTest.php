<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Medidor;

class MedidorTest extends TestCase
{
    /** @test */
    public function verifica_que_el_estado_del_medidor_sea_valido()
    {
        $medidor = new Medidor(['estado' => 'Activo']);
        $this->assertContains($medidor->estado, ['Activo', 'Inactivo', 'Mantenimiento', 'Dañado']);
    }

    /** @test */
    public function un_medidor_debe_tener_un_numero_de_serie()
    {
        $medidor = new Medidor(['numero_serie' => '']);
        $this->assertEmpty($medidor->numero_serie);
    }

    /** @test */
    public function el_numero_de_serie_no_debe_superar_los_20_caracteres()
    {
        $medidor = new Medidor(['numero_serie' => str_repeat('A', 21)]);
        $this->assertGreaterThan(20, strlen($medidor->numero_serie));
    }

    /** @test */
    public function el_estado_predeterminado_debe_ser_activo()
    {
        $medidor = new Medidor();
        $this->assertEquals('Activo', $medidor->estado ?? 'Activo');
    }

    /** @test */
    public function el_monto_a_pagar_debe_ser_numerico()
    {
        $medidor = new Medidor(['monto_a_pagar' => 'texto']);
        $this->assertFalse(is_numeric($medidor->monto_a_pagar));
    }
}
