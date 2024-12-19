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
            $table->integer('cantidad_producto')->default(0); // Siempre habilitado con valor por defecto 0
            $table->decimal('precio_venta', 10, 2);
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
