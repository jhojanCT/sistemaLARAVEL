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
        Schema::create('aperturas_diarias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique(); // Cada día solo puede haber una apertura
            $table->decimal('saldo_inicial', 10, 2)->default(0); // Dinero inicial del día
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_diarias');
    }
};
