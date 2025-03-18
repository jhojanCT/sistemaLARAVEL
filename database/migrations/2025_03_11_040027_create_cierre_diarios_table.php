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
        Schema::create('cierres_diarios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique();
            $table->decimal('total_ventas_materia_prima', 10, 2)->default(0);
            $table->decimal('total_ventas_producto', 10, 2)->default(0);
            $table->decimal('total_pagos', 10, 2)->default(0);
            $table->decimal('saldo_final', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_diarios');
    }
};
