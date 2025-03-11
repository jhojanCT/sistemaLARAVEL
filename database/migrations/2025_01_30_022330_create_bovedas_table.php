<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBovedasTable extends Migration
{
    public function up()
    {
        Schema::create('bovedas', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->decimal('saldo', 15, 2)->default(0); // Saldo inicial con dos decimales
            $table->timestamps(); // Created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('bovedas');
    }
}

