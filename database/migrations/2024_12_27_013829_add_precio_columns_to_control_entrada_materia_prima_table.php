<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrecioColumnsToControlEntradaMateriaPrimaTable extends Migration
{
    public function up()
    {
        Schema::table('control_entrada_materia_prima', function (Blueprint $table) {
            $table->decimal('precio_unitario_por_kilo', 8, 2)->after('cantidad');
            $table->decimal('precio_total', 10, 2)->after('precio_unitario_por_kilo');
        });
    }

    public function down()
    {
        Schema::table('control_entrada_materia_prima', function (Blueprint $table) {
            $table->dropColumn('precio_unitario_por_kilo');
            $table->dropColumn('precio_total');
        });
    }
}
