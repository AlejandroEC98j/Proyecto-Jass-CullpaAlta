<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('lecturas_medidor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medidor_id')->constrained('medidores')->onDelete('cascade');
            $table->dateTime('fecha_lectura');
            $table->decimal('consumo', 10, 2); // m³ consumidos
            $table->decimal('presion', 5, 2)->nullable(); // Opcional
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('lecturas_medidor');
    }
};
