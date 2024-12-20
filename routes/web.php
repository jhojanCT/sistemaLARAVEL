<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AlmacenFiltradoController;
use App\Http\Controllers\AlmacenSinFiltroController;
use App\Http\Controllers\ControlEntradaMateriaPrimaController;
use App\Http\Controllers\EntradaProduccionController;
use App\Http\Controllers\SalidaProduccionController;
use App\Http\Controllers\MateriaPrimaController;




// Rutas
Route::resource('materias_primas', MateriaPrimaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('filtros', FiltroController::class);
Route::resource('almacen_filtrado', AlmacenFiltradoController::class);
Route::resource('almacen_sin_filtro', AlmacenSinFiltroController::class);
Route::resource('entradas_produccion', EntradaProduccionController::class);
Route::resource('salidas_produccion', SalidaProduccionController::class);
Route::post('salidas_produccion/addToProducts/{id}', [SalidaProduccionController::class, 'addToProducts'])->name('salidas_produccion.addToProducts');
Route::resource('clientes', ClienteController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('roles', RolController::class);
Route::resource('control_entrada_materia_prima', ControlEntradaMateriaPrimaController::class);
Route::post('entradas_produccion/{id}/finalizar', [EntradaProduccionController::class, 'finalizar'])->name('entradas_produccion.finalizar');
Route::put('salidas_produccion/{salida}/aprobar', [SalidaProduccionController::class, 'aprobar'])->name('salidas_produccion.aprobar');
Route::delete('salidas_produccion/{salida}', [SalidaProduccionController::class, 'eliminar'])->name('salidas_produccion.eliminar');
Route::put('salidas_produccion/{salida}/aprobar', [SalidaProduccionController::class, 'aprobar'])->name('salidas_produccion.aprobar');



Route::get('/', function () {
    return view('welcome');
});
