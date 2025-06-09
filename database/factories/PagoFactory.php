<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pago;
use App\Models\Factura;

class PagoFactory extends Factory
{
    protected $model = Pago::class;
    public function definition()
    {
        return [
            'factura_id' => Factura::factory(),
            'monto_pagado' => $this->faker->randomFloat(2, 10, 500),
            'fecha_pago' => $this->faker->date(),
        ];
    }
}