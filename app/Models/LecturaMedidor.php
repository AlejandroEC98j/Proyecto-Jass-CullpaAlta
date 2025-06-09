<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturaMedidor extends Model {
    use HasFactory;

    protected $fillable = ['medidor_id', 'fecha_lectura', 'consumo', 'presion', 'observaciones'];

    public function medidor() {
        return $this->belongsTo(Medidor::class);
    }
}
