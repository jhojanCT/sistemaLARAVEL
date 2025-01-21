<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0); // Para menús anidados
            $table->string('name'); // Nombre del menú
            $table->string('icon')->nullable(); // Icono opcional para el menú
            $table->string('menu_url')->nullable(); // URL o ruta del menú
            $table->tinyInteger('status')->default(0); // Estado del menú (activo/inactivo)
            $table->timestamps(); // Timestamps automáticos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
