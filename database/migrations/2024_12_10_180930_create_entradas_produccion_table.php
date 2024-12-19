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
        Schema::create('entradas_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('almacen_filtrado_id')->constrained('almacen_filtrado')->onDelete('cascade');
            $table->integer('materia_prima_en_uso'); // Cantidad utilizada
            $table->string('estado_produccion')->default('en proceso'); // Nuevo campo
            $table->timestamp('fecha_entrada')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas_produccion');
    }
};
