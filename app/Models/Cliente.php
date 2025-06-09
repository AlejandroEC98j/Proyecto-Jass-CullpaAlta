<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'dni',
        'nombre',
        'direccion',
        'telefono',
        'correo',
        'tipo_contrato'
    ];

    // Relación: Un cliente puede tener un medidor
    public function medidor()
    {
        return $this->hasOne(Medidor::class);
    }
}
