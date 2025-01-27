<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credito_compras', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->unsignedBigInteger('control_entrada_id'); // Clave foránea hacia control_entrada_materia_prima
            $table->unsignedBigInteger('proveedor_id'); // Clave foránea hacia proveedores
            $table->decimal('monto_total', 10, 2); // Monto total del crédito
            $table->decimal('monto_pagado', 10, 2); // Monto pagado hasta el momento
            $table->string('estado')->default('Pendiente'); // Por defecto será 'Pendiente'
            $table->date('fecha'); // Fecha del crédito
            $table->timestamps(); // Timestamps (created_at y updated_at)

            // Definir la clave foránea para 'control_entrada_id'
            $table->foreign('control_entrada_id')
                  ->references('id')->on('control_entrada_materia_prima')
                  ->onDelete('cascade'); // Si se elimina la entrada de materia prima, se eliminan los créditos asociados

            // Definir la clave foránea para 'proveedor_id'
            $table->foreign('proveedor_id')
                  ->references('id')->on('proveedores')
                  ->onDelete('cascade'); // Si se elimina el proveedor, se eliminan los créditos asociados
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credito_compras', function (Blueprint $table) {
            // Eliminar las relaciones de claves foráneas
            $table->dropForeign(['control_entrada_id']);
            $table->dropForeign(['proveedor_id']);
        });

        // Eliminar la tabla
        Schema::dropIfExists('credito_compras');
    }
}
