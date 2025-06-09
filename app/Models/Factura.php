<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Si el nombre de la tabla es diferente a 'facturas', agrega esta línea
    // protected $table = 'nombre_de_tu_tabla';

    // Campos que son fechas
    protected $dates = ['fecha_emision', 'fecha_vencimiento'];

    public function getFechaEmisionAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }

    public function getFechaVencimientoAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }

    // Definir los campos asignables
    protected $fillable = [
        'cliente_id',
        'numero_factura',
        'monto_total',
        'estado',
        'fecha_emision',
        'fecha_vencimiento',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

}
