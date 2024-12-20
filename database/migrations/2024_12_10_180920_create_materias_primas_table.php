<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasPrimasTable extends Migration
{
    public function up()
    {
        Schema::create('materias_primas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre de la materia prima
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias_primas');
    }
}
