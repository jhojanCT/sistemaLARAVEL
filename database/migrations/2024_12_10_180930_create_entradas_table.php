<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->string('producto');
            $table->string('proveedor');
            $table->decimal('existencia_total', 10, 2); // 10 kg + 8 kg
            $table->decimal('existencia_actual', 10, 2); // 8 kg filtrada
            $table->decimal('existencia_actual_en_uso', 10, 2); // Ej. 2 kg en uso
            $table->decimal('porcentaje_elaboracion', 5, 2); // Ej. 20% de los 10 kg
            $table->decimal('precio_venta', 10, 2); // El precio por kg
            $table->string('supervisor');
            $table->date('fecha_entrada');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
