<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('numero_factura')->unique();
            $table->decimal('monto_total', 10, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'vencido'])->default('pendiente');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento'); // Esta se generará automáticamente
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};

