<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AlmacenFiltradoController;
use App\Http\Controllers\AlmacenSinFiltroController;
use App\Http\Controllers\ControlEntradaMateriaPrimaController;


// Rutas
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('filtros', FiltroController::class);
Route::resource('almacen_filtrado', AlmacenFiltradoController::class);
Route::resource('almacen_sin_filtro', AlmacenSinFiltroController::class);
Route::resource('entradas', EntradaController::class);
Route::resource('salidas', SalidaController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('roles', RolController::class);
Route::resource('control_entrada_materia_prima', ControlEntradaMateriaPrimaController::class);
Route::post('/control-entrada-materia-prima', [ControlEntradaMateriaPrimaController::class, 'store'])->name('control_entrada_materia_prima.store');




Route::get('/', function () {
    return view('welcome');
});
