<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VentaMateriaPrimaController;
use App\Http\Controllers\VentaProductoController;
use App\Http\Controllers\CuentaController;
use App\Http\Middleware\RolePermissionMiddleware;
use App\Http\Kernel;

/// Rutas para login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Ruta para logout
Route::post('logout', function () {
    Auth::logout(); // Cierra la sesión del usuario
    return redirect()->route('login'); // Redirige a la página de login
})->name('logout');

// Rutas protegidas por autenticación
Route::middleware('auth', 'role_permission')->group(function () {
    Route::resource('cuentas', CuentaController::class);
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
    

    Route::resource('control_entrada_materia_prima', ControlEntradaMateriaPrimaController::class);
    Route::post('entradas_produccion/{id}/finalizar', [EntradaProduccionController::class, 'finalizar'])->name('entradas_produccion.finalizar');
    Route::put('salidas_produccion/{salida}/aprobar', [SalidaProduccionController::class, 'aprobar'])->name('salidas_produccion.aprobar');
    Route::delete('salidas_produccion/{salida}', [SalidaProduccionController::class, 'eliminar'])->name('salidas_produccion.eliminar');
    Route::put('salidas_produccion/{salida}/aprobar', [SalidaProduccionController::class, 'aprobar'])->name('salidas_produccion.aprobar');
    Route::prefix('ventas/productos')->name('ventas.productos.')->group(function () {
        Route::get('/', [VentaProductoController::class, 'index'])->name('index');
        Route::get('/create', [VentaProductoController::class, 'create'])->name('create');
        Route::post('/', [VentaProductoController::class, 'store'])->name('store');
        Route::get('/{venta}/edit', [VentaProductoController::class, 'edit'])->name('edit');
        Route::put('/{venta}', [VentaProductoController::class, 'update'])->name('update');
        Route::delete('/{venta}', [VentaProductoController::class, 'destroy'])->name('destroy');
    });
    
}); // Rutas para ventas de materia prima


Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('role/delete/{id}','RoleController@destroy');
   Route::post('role/update/{id}','RoleController@update');

Route::prefix('ventas/materia-prima')->name('ventas.materia_prima.')->group(function () {
    Route::get('/', [VentaMateriaPrimaController::class, 'index'])->name('index');
    Route::get('/create', [VentaMateriaPrimaController::class, 'create'])->name('create');
    Route::post('/', [VentaMateriaPrimaController::class, 'store'])->name('store');
    Route::get('/{venta}/edit', [VentaMateriaPrimaController::class, 'edit'])->name('edit');
    Route::put('/{venta}', [VentaMateriaPrimaController::class, 'update'])->name('update');
    Route::delete('/{venta}', [VentaMateriaPrimaController::class, 'destroy'])->name('destroy');
});

Route::prefix('materias-primas')->name('materias_primas.')->group(function () {
    // Ruta para mostrar la lista de materias primas
    Route::get('/', [MateriaPrimaController::class, 'index'])->name('index');

    // Ruta para mostrar el formulario de creación
    Route::get('/create', [MateriaPrimaController::class, 'create'])->name('create');

    // Ruta para almacenar una nueva materia prima
    Route::post('/', [MateriaPrimaController::class, 'store'])->name('store');

    // Ruta para mostrar el formulario de edición de una materia prima específica
    Route::get('/{id}/edit', [MateriaPrimaController::class, 'edit'])->name('edit');

    // Ruta para actualizar una materia prima
    Route::put('/{materias_prima}', [MateriaPrimaController::class, 'update'])->name('update');

    // Ruta para eliminar una materia prima
    Route::delete('/{materiaPrima}', [MateriaPrimaController::class, 'destroy'])->name('destroy');
});

Route::get('/', function () {
    return view('welcome'); 
});