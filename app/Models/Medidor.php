<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medidor extends Model {
    use HasFactory;

    protected $table = 'medidores';

    protected $fillable = ['cliente_id', 'numero_serie', 'direccion', 'estado'];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function lecturas() {
        return $this->hasMany(LecturaMedidor::class);
    }
}
