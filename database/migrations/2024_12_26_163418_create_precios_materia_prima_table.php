<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('precios_materia_prima', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia_prima_id');
            $table->decimal('precio_unitario', 10, 2);
            $table->timestamp('fecha_actualizacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            // Relación con la tabla materias_primas
            $table->foreign('materia_prima_id')->references('id')->on('materias_primas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios_materia_prima');
    }
};
