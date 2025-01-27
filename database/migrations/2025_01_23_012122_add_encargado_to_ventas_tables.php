<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEncargadoToVentasTables extends Migration
{
    public function up()
    {
        Schema::table('ventas_materia_prima', function (Blueprint $table) {
            $table->string('encargado')->nullable()->after('saldo_deuda');
        });

        Schema::table('ventas_productos', function (Blueprint $table) {
            $table->string('encargado')->nullable()->after('saldo_deuda');
        });
    }

    public function down()
    {
        Schema::table('ventas_materia_prima', function (Blueprint $table) {
            $table->dropColumn('encargado');
        });

        Schema::table('ventas_productos', function (Blueprint $table) {
            $table->dropColumn('encargado');
        });
    }
}
