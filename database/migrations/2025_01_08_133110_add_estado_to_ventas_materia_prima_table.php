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
        Schema::table('ventas_materia_prima', function (Blueprint $table) {
            $table->string('estado')->default('pendiente'); // Puedes cambiar el valor por defecto
        });
    }
    
    public function down()
    {
        Schema::table('ventas_materia_prima', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
    
};
