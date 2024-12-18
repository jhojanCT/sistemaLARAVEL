<?php

namespace App\Http\Controllers;

use App\Models\ControlEntradaMateriaPrima;
use App\Models\Proveedor;
use App\Models\AlmacenSinFiltro;
use Illuminate\Http\Request;

class ControlEntradaMateriaPrimaController extends Controller
{
    // Mostrar todas las entradas de materia prima
    public function index()
    {
        $entradas = ControlEntradaMateriaPrima::with('proveedor')->get(); // Recupera todas las entradas con su proveedor
        return view('control_entrada_materia_prima.index', compact('entradas'));
    }

    // Mostrar el formulario para crear una nueva entrada de materia prima
    public function create()
    {
        $proveedores = Proveedor::all();
        return view('control_entrada_materia_prima.create', compact('proveedores'));
    }
    
    // Guardar una nueva entrada de materia prima
    public function store(Request $request)
    {
        // Validación de los datos (puedes agregar más validaciones si es necesario)
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'materia_prima' => 'required|string',
            'cantidad' => 'required|numeric',
            'encargado' => 'required|string',
            'fecha_llegada' => 'required|date',
        ]);
    
        // Crear el almacen sin filtro si no existe
        $almacenSinFiltro = AlmacenSinFiltro::firstOrCreate(
            [
                'proveedor_id' => $validated['proveedor_id'],
                'materia_prima' => $validated['materia_prima'],
            ]
        );
    
        // Crear la entrada en ControlEntradaMateriaPrima
        $entrada = ControlEntradaMateriaPrima::create([
            'proveedor_id' => $validated['proveedor_id'],
            'materia_prima' => $validated['materia_prima'], // No se guarda directamente, pero es para la creación
            'cantidad' => $validated['cantidad'],
            'encargado' => $validated['encargado'],
            'fecha_llegada' => $validated['fecha_llegada'],
            'almacen_sin_filtro_id' => $almacenSinFiltro->id,  // Asignar el ID del almacén sin filtro
        ]);
    
        // Ahora, actualizar la cantidad total en el AlmacenSinFiltro
        $almacenSinFiltro->cantidad_total += $entrada->cantidad;
        $almacenSinFiltro->save();
    
        return redirect()->route('control_entrada_materia_prima.index');
    }
    

    // Mostrar el formulario para editar una entrada de materia prima
    public function edit($id)
    {
        $entrada = ControlEntradaMateriaPrima::findOrFail($id);
        $proveedores = Proveedor::all();
        return view('control_entrada_materia_prima.edit', compact('entrada', 'proveedores'));
    }

    // Actualizar una entrada de materia prima
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'materia_prima' => 'required|string',
            'cantidad' => 'required|numeric',
            'encargado' => 'required|string',
            'fecha_llegada' => 'required|date',
        ]);
    
        // Encontrar la entrada y actualizarla
        $entrada = ControlEntradaMateriaPrima::findOrFail($id);
        $entrada->update([
            'proveedor_id' => $request->proveedor_id,
            'materia_prima' => $request->materia_prima,
            'cantidad' => $request->cantidad,
            'encargado' => $request->encargado,
            'fecha_llegada' => $request->fecha_llegada,
        ]);
    
        // Actualizar la tabla 'almacen_sin_filtro'
        $almacen = AlmacenSinFiltro::where('materia_prima', $request->materia_prima)
                                   ->where('proveedor_id', $request->proveedor_id)
                                   ->first();

        if ($almacen) {
            // Si existe, actualizar la cantidad total (sumar la cantidad)
            $almacen->update([
                'cantidad_total' => \DB::raw('cantidad_total + ' . $request->cantidad), // Sumar la cantidad al total
            ]);
        }

        return redirect()->route('control_entrada_materia_prima.index')
                         ->with('success', 'Entrada de Materia Prima actualizada correctamente.');
    }
}
