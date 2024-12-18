<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlEntradaMateriaPrimaTable extends Migration
{
    public function up()
    {
        Schema::create('control_entrada_materia_prima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->string('materia_prima');
            $table->decimal('cantidad', 8, 2);
            $table->string('encargado');
            $table->date('fecha_llegada');
            $table->foreignId('almacen_sin_filtro_id')->nullable()->constrained('almacen_sin_filtro')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('control_entrada_materia_prima');
    }
}
