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
        Schema::table('ventas_productos', function (Blueprint $table) {
            $table->decimal('saldo_deuda', 10, 2)->default(0); // O el tipo adecuado según tu lógica
        });
    }
    
    public function down()
    {
        Schema::table('ventas_productos', function (Blueprint $table) {
            $table->dropColumn('saldo_deuda');
        });
    }
    
};
