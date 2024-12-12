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
        Schema::create('filtros', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->string('producto');
            $table->string('proveedor');
            $table->decimal('existencia_total_inicial', 10, 2); // 10 kg
            $table->decimal('desperdicio', 10, 2); // 2 kg
            $table->decimal('existencia_total_filtrada', 10, 2); // 8 kg
            $table->string('filtrado_supervisor');
            $table->date('fecha_filtro');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filtros');
    }
};
