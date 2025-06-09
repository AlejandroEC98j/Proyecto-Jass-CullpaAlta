<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;
    public function definition()
    {
        return [
            'dni' => $this->faker->unique()->numerify('########'),
            'nombre' => $this->faker->name,
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
            'correo' => $this->faker->safeEmail,
            'tipo_contrato' => $this->faker->randomElement(['con medidor', 'sin medidor']),
        ];
    }
}