<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas_materia_prima', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia_prima_id');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('precio_total', 10, 2);
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('cuenta_id'); // Agregada la columna para cuentas
            $table->boolean('a_credito')->default(false); // Nuevo campo para saber si es a crédito
            $table->decimal('cuota_inicial', 10, 2)->nullable(); // Nuevo campo para la cuota inicial
            $table->decimal('saldo_deuda', 10, 2)->nullable(); // Nuevo campo para el saldo de la deuda
            $table->timestamp('fecha_venta')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
    
            // Relación con la tabla materias_primas
            $table->foreign('materia_prima_id')->references('id')->on('materias_primas')->onDelete('cascade');
    
            // Relación con la tabla clientes
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
    
            // Relación con la tabla cuentas
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_materia_prima');
    }
};
