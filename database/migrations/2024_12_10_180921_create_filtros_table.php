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
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->foreignId('almacen_sin_filtro_id')->constrained('almacen_sin_filtro')->onDelete('cascade');
            // Añadir relación con almacen_filtrado
            $table->foreignId('almacen_filtrado_id')->constrained('almacen_filtrado')->onDelete('cascade');
            $table->decimal('cantidad_usada', 10, 2);
            $table->decimal('desperdicio', 10, 2);
            $table->decimal('existencia_filtrada', 10, 2);
            $table->string('supervisor');
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
