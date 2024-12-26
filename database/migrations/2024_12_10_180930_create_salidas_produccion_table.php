<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidasProduccionTable extends Migration
{
    public function up()
    {
        Schema::create('salidas_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_produccion_id')->constrained('entradas_produccion');
            $table->integer('cantidad_productos_hechos');
            $table->decimal('cantidad_materia_prima_en_uso', 8, 2); // Cantidad de materia prima en uso
            $table->decimal('precio_produccion', 10, 2); // Precio de producción
            $table->enum('esperado_aprobacion', ['esperando aprobacion', 'aprobado', 'rechazado'])->default('esperando aprobacion');
            $table->date('fecha_salida');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salidas_produccion');
    }
}
