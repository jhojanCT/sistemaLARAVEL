<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlEntradaMateriaPrimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_entrada_materia_prima', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->unsignedBigInteger('proveedor_id'); // Relación con proveedor
            $table->unsignedBigInteger('materia_prima_id'); // Relación con materia prima
            $table->decimal('cantidad', 8, 2); // Cantidad
            $table->decimal('precio_unitario_por_kilo', 8, 2); // Precio unitario por kilo
            $table->decimal('precio_total', 10, 2); // Precio total
            $table->string('encargado'); // Encargado de la entrada
            $table->date('fecha_llegada'); // Fecha de llegada
            $table->unsignedBigInteger('almacen_sin_filtro_id')->nullable(); // Relación con almacén sin filtro
            $table->tinyInteger('compra_credito')->default(0); // Indicador de crédito (sin 'after')
            $table->timestamps(); // Timestamps (created_at y updated_at)

            // Definir las claves foráneas
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('materia_prima_id')->references('id')->on('materias_primas')->onDelete('cascade');
            $table->foreign('almacen_sin_filtro_id')->references('id')->on('almacen_sin_filtro')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_entrada_materia_prima', function (Blueprint $table) {
            // Eliminar las relaciones de claves foráneas
            $table->dropForeign(['proveedor_id']);
            $table->dropForeign(['materia_prima_id']);
            $table->dropForeign(['almacen_sin_filtro_id']);
        });

        // Eliminar la tabla
        Schema::dropIfExists('control_entrada_materia_prima');
    }
}
