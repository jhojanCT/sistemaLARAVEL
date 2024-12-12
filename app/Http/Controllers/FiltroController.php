<?php

namespace App\Http\Controllers;

use App\Models\Filtro;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class FiltroController extends Controller
{
    public function index()
    {
        // Recuperar todos los filtros con las relaciones
        $filtros = Filtro::all();
        return view('filtros.index', compact('filtros')); // Retornar vista con los datos
    }

    public function create()
    {
        // Recuperar datos necesarios para el formulario
        $categorias = Categoria::all();
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $usuarios = User::all(); // Supervisores para filtrado

        return view('filtros.create', compact('categorias', 'productos', 'usuarios', 'proveedores')); // Retornar vista de creación
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'categoria' => 'required|string|exists:categorias,nombre',
            'producto' => 'required|string|exists:productos,nombre',
            'proveedor' => 'required|string|exists:proveedores,nombre',
            'existencia_total_inicial' => 'required|numeric|min:0',
            'desperdicio' => 'required|numeric|min:0',
            'filtrado_supervisor' => 'required|string',
            'fecha_filtro' => 'required|date',
        ]);
    
        // Calcular la existencia filtrada
        $existenciaFiltrada = $request->existencia_total_inicial - $request->desperdicio;
    
        // Crear el filtro
        Filtro::create([
            'categoria' => $request->categoria,
            'producto' => $request->producto,
            'proveedor' => $request->proveedor,
            'existencia_total_inicial' => $request->existencia_total_inicial,
            'desperdicio' => $request->desperdicio,
            'existencia_total_filtrada' => $existenciaFiltrada, // Guardar existencia filtrada
            'filtrado_supervisor' => $request->filtrado_supervisor,
            'fecha_filtro' => $request->fecha_filtro,
        ]);
    
        return redirect()->route('filtros.index')->with('success', 'Filtro registrado exitosamente.');
    }
    

    public function edit(Filtro $filtro)
    {
        // Recuperar datos para el formulario de edición
        $categorias = Categoria::all();
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $usuarios = User::all(); // Supervisores

        return view('filtros.edit', compact('filtro', 'categorias', 'productos', 'usuarios', 'proveedores')); // Retornar vista de edición
    }

    public function update(Request $request, $id)
{
    // Validar los datos
    $request->validate([
        'categoria' => 'required|string|exists:categorias,nombre',
        'producto' => 'required|string|exists:productos,nombre',
        'proveedor' => 'required|string|exists:proveedores,nombre',
        'existencia_total_inicial' => 'required|numeric|min:0',
        'desperdicio' => 'required|numeric|min:0',
        'filtrado_supervisor' => 'required|string',
        'fecha_filtro' => 'required|date',
    ]);

    // Buscar el filtro
    $filtro = Filtro::findOrFail($id);

    // Calcular la nueva existencia filtrada
    $existenciaFiltrada = $request->existencia_total_inicial - $request->desperdicio;

    // Actualizar el filtro
    $filtro->update([
        'categoria' => $request->categoria,
        'producto' => $request->producto,
        'proveedor' => $request->proveedor,
        'existencia_total_inicial' => $request->existencia_total_inicial,
        'desperdicio' => $request->desperdicio,
        'existencia_total_filtrada' => $existenciaFiltrada, // Guardar existencia filtrada actualizada
        'filtrado_supervisor' => $request->filtrado_supervisor,
        'fecha_filtro' => $request->fecha_filtro,
    ]);

    return redirect()->route('filtros.index')->with('success', 'Filtro actualizado exitosamente.');
}


    public function destroy(Filtro $filtro)
    {
        // Eliminar el filtro
        $filtro->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('filtros.index')->with('success', 'Filtro eliminado exitosamente.');
    }
}
