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
        Schema::create('salidas_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_produccion_id')->constrained('entradas_produccion')->onDelete('cascade');
            $table->integer('cantidad');
            $table->timestamp('fecha_hora_salida')->useCurrent();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas_produccion');
    }
};
