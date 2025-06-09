<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('medidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null'); 
            $table->string('numero_serie')->unique();
            $table->string('direccion');
            $table->enum('estado', ['Activo', 'Inactivo', 'Mantenimiento', 'Dañado'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('medidores');
    }
};
