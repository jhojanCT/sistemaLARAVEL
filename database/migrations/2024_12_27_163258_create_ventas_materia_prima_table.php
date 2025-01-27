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
            $table->unsignedBigInteger('cuenta_id');
            $table->boolean('a_credito')->default(false);
            $table->decimal('saldo_deuda', 10, 2)->default(0);
            $table->string('estado')->default('pendiente');
            $table->timestamp('fecha_venta')->useCurrent();
            $table->timestamps();

            $table->foreign('materia_prima_id')->references('id')->on('materias_primas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
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
