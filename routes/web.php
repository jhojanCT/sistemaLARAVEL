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

// Rutas para Categorías
Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('categorias.index'); // Ver todas las categorías
    Route::get('create', [CategoriaController::class, 'create'])->name('categorias.create'); // Crear nueva categoría
    Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store'); // Guardar categoría
    Route::get('{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit'); // Editar categoría
    Route::put('{categoria}', [CategoriaController::class, 'update'])->name('categorias.update'); // Actualizar categoría
    Route::delete('{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy'); // Eliminar categoría
});

// Rutas para Productos
Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('productos.index'); // Ver todos los productos
    Route::get('create', [ProductoController::class, 'create'])->name('productos.create'); // Crear nuevo producto
    Route::post('/', [ProductoController::class, 'store'])->name('productos.store'); // Guardar producto
    Route::get('{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit'); // Editar producto
    Route::put('{producto}', [ProductoController::class, 'update'])->name('productos.update'); // Actualizar producto
    Route::delete('{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy'); // Eliminar producto
});

// Rutas para Proveedores
Route::prefix('proveedores')->group(function () {
    Route::get('/', [ProveedorController::class, 'index'])->name('proveedores.index'); // Ver todos los proveedores
    Route::get('create', [ProveedorController::class, 'create'])->name('proveedores.create'); // Crear nuevo proveedor
    Route::post('/', [ProveedorController::class, 'store'])->name('proveedores.store'); // Guardar proveedor
    Route::get('{proveedor}/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit'); // Editar proveedor
    Route::put('{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update'); // Actualizar proveedor
    Route::delete('{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy'); // Eliminar proveedor
});

// Rutas para Filtros
Route::prefix('filtros')->group(function () {
    Route::get('/', [FiltroController::class, 'index'])->name('filtros.index'); // Ver todos los filtros
    Route::get('create', [FiltroController::class, 'create'])->name('filtros.create'); // Crear nuevo filtro
    Route::post('/', [FiltroController::class, 'store'])->name('filtros.store'); // Guardar filtro
    Route::get('{filtro}/edit', [FiltroController::class, 'edit'])->name('filtros.edit'); // Editar filtro
    Route::put('{filtro}', [FiltroController::class, 'update'])->name('filtros.update'); // Actualizar filtro
    Route::delete('{filtro}', [FiltroController::class, 'destroy'])->name('filtros.destroy'); // Eliminar filtro
});

// Rutas para Entradas
Route::prefix('entradas')->group(function () {
    Route::get('/', [EntradaController::class, 'index'])->name('entradas.index'); // Ver todas las entradas
    Route::get('create', [EntradaController::class, 'create'])->name('entradas.create'); // Crear nueva entrada
    Route::post('/', [EntradaController::class, 'store'])->name('entradas.store'); // Guardar entrada
    Route::get('{entrada}/edit', [EntradaController::class, 'edit'])->name('entradas.edit'); // Editar entrada
    Route::put('{entrada}', [EntradaController::class, 'update'])->name('entradas.update'); // Actualizar entrada
    Route::delete('{entrada}', [EntradaController::class, 'destroy'])->name('entradas.destroy'); // Eliminar entrada
});

// Rutas para Salidas
Route::prefix('salidas')->group(function () {
    Route::get('/', [SalidaController::class, 'index'])->name('salidas.index'); // Ver todas las salidas
    Route::get('create', [SalidaController::class, 'create'])->name('salidas.create'); // Crear nueva salida
    Route::post('/', [SalidaController::class, 'store'])->name('salidas.store'); // Guardar salida
    Route::get('{salida}/edit', [SalidaController::class, 'edit'])->name('salidas.edit'); // Editar salida
    Route::put('{salida}', [SalidaController::class, 'update'])->name('salidas.update'); // Actualizar salida
    Route::delete('{salida}', [SalidaController::class, 'destroy'])->name('salidas.destroy'); // Eliminar salida
});

// Rutas para Clientes
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index'); // Ver todos los clientes
    Route::get('create', [ClienteController::class, 'create'])->name('clientes.create'); // Crear nuevo cliente
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store'); // Guardar cliente
    Route::get('{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit'); // Editar cliente
    Route::put('{cliente}', [ClienteController::class, 'update'])->name('clientes.update'); // Actualizar cliente
    Route::delete('{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy'); // Eliminar cliente
});

// Rutas para Usuarios
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index'); // Ver todos los usuarios
    Route::get('create', [UsuarioController::class, 'create'])->name('usuarios.create'); // Crear nuevo usuario
    Route::post('/', [UsuarioController::class, 'store'])->name('usuarios.store'); // Guardar usuario
    Route::get('{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit'); // Editar usuario
    Route::put('{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update'); // Actualizar usuario
    Route::delete('{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy'); // Eliminar usuario
});

// Rutas para Roles
Route::prefix('roles')->group(function () {
    Route::get('/', [RolController::class, 'index'])->name('roles.index'); // Ver todos los roles
    Route::get('create', [RolController::class, 'create'])->name('roles.create'); // Crear nuevo rol
    Route::post('/', [RolController::class, 'store'])->name('roles.store'); // Guardar rol
    Route::get('{rol}/edit', [RolController::class, 'edit'])->name('roles.edit'); // Editar rol
    Route::put('{rol}', [RolController::class, 'update'])->name('roles.update'); // Actualizar rol
    Route::delete('{rol}', [RolController::class, 'destroy'])->name('roles.destroy'); // Eliminar rol
});


Route::get('/', function () {
    return view('welcome');
});
