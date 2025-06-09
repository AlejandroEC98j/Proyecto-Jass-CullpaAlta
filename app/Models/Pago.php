<?php

// app/Models/Pago.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'monto_pagado',
        'fecha_pago',
    ];

    // Relación con la factura
    public function factura()
    {
        return $this->belongsTo(Factura::class); // Relación con el modelo Factura
    }
}
