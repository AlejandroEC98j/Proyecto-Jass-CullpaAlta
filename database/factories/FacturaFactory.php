<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Support\Carbon; 

class FacturaFactory extends Factory
{
    protected $model = Factura::class;
    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(), // Asegurar un cliente asociado
            'numero_factura' => $this->faker->unique()->numerify('FAC-#####'), // Genera un número único
            'monto_total' => $this->faker->randomFloat(2, 50, 1000),
            'estado' => $this->faker->randomElement(['pendiente', 'pagado', 'vencido']),
            'fecha_emision' => Carbon::now(),
            'fecha_vencimiento' => Carbon::now()->addDays(45),
        ];
    }
}