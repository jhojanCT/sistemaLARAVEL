<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductoInFiltrosTable extends Migration
{
    public function up(): void
    {
        Schema::table('filtros', function (Blueprint $table) {
            $table->unsignedBigInteger('producto_id')->nullable()->after('categoria'); // Agregar producto_id
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade'); // Definir la clave foránea

            $table->dropColumn('producto'); // Eliminar el campo producto
        });
    }

    public function down(): void
    {
        Schema::table('filtros', function (Blueprint $table) {
            $table->string('producto')->after('categoria'); // Restaurar el campo producto como string
            $table->dropForeign(['producto_id']); // Eliminar la clave foránea
            $table->dropColumn('producto_id'); // Eliminar producto_id
        });
    }
}

