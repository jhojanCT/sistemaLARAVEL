<?php

namespace App\Http\Controllers;

use App\Models\VentaMateriaPrima;
use App\Models\AlmacenFiltrado;
use App\Models\MateriaPrima;
use App\Models\Cliente;
use App\Models\Cuenta;
use Illuminate\Http\Request;

class VentaMateriaPrimaController extends Controller
{
    /**
     * Muestra la lista de todas las ventas de materia prima.
     */
    public function index()
    {
        // Obtener todas las cuentas, incluyendo la Cuenta General
        $cuentas = Cuenta::all();

        // Obtener las ventas de todas las cuentas, incluyendo "Cuenta General"
        $ventas = VentaMateriaPrima::with(['materiaPrima', 'cliente', 'cuenta'])->get();

        return view('ventas.materia_prima.index', compact('ventas', 'cuentas'));
    }

    /**
     * Muestra el formulario para crear una nueva venta de materia prima.
     */
    public function create()
    {
        $materiasPrimas = AlmacenFiltrado::all(); // Recuperar las materias primas filtradas
        $clientes = Cliente::all();
        $cuentas = Cuenta::all(); // Recuperar las cuentas disponibles
        return view('ventas.materia_prima.create', compact('materiasPrimas', 'clientes', 'cuentas'));
    }

    /**
     * Almacena una nueva venta de materia prima.
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'materia_prima_filtrada_id' => 'required|exists:almacen_filtrado,id', // Usamos id de 'almacen_filtrado'
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id', // Puede ser nulo
            'cuenta_id' => 'required|exists:cuentas,id', // Debe incluirse la cuenta
        ]);

        // Obtener el registro de materia prima filtrada
        $almacenFiltrado = AlmacenFiltrado::findOrFail($request->materia_prima_filtrada_id);

        // Verificar si hay suficiente stock disponible en el almacen filtrado
        if ($almacenFiltrado->cantidad_materia_prima_filtrada < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        // Calcular el precio total
        $precioTotal = $request->cantidad * $request->precio_unitario;

        // Crear la venta
        $venta = VentaMateriaPrima::create([
            'materia_prima_id' => $almacenFiltrado->materia_prima_filtrada, // Usar el campo 'materia_prima_filtrada' para referencia
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'precio_total' => $precioTotal,
            'cliente_id' => $request->cliente_id,
            'cuenta_id' => $request->cuenta_id, // Asociar la venta con la cuenta
            'fecha_venta' => now(),
        ]);

        // Actualizar el stock del almacen filtrado después de la venta
        VentaMateriaPrima::actualizarStock($almacenFiltrado->materia_prima_filtrada, $request->cantidad);

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta registrada con éxito');
    }

    /**
     * Muestra el formulario para editar una venta existente.
     */
    public function edit($id)
    {
        $venta = VentaMateriaPrima::findOrFail($id);
        $materiasPrimas = AlmacenFiltrado::all(); // Recuperar las materias primas filtradas
        $clientes = Cliente::all();
        $cuentas = Cuenta::all(); // Recuperar las cuentas disponibles
        return view('ventas.materia_prima.edit', compact('venta', 'materiasPrimas', 'clientes', 'cuentas'));
    }

    /**
     * Actualiza una venta existente.
     */
    public function update(Request $request, $id)
    {
        $venta = VentaMateriaPrima::findOrFail($id);

        // Validación de los datos de entrada
        $request->validate([
            'materia_prima_filtrada_id' => 'required|exists:almacen_filtrado,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id', // Puede ser nulo
            'cuenta_id' => 'required|exists:cuentas,id', // Debe incluirse la cuenta
        ]);

        // Obtener el registro de materia prima filtrada
        $almacenFiltrado = AlmacenFiltrado::findOrFail($request->materia_prima_filtrada_id);

        // Verificar si hay suficiente stock disponible en el almacen filtrado
        if ($almacenFiltrado->cantidad_materia_prima_filtrada < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        // Calcular el precio total
        $precioTotal = $request->cantidad * $request->precio_unitario;

        // Actualizar la venta
        $venta->update([
            'materia_prima_id' => $almacenFiltrado->materia_prima_filtrada, // Usar el campo 'materia_prima_filtrada' para referencia
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'precio_total' => $precioTotal,
            'cliente_id' => $request->cliente_id,
            'cuenta_id' => $request->cuenta_id, // Actualizar la cuenta asociada
        ]);

        // Actualizar el stock del almacen filtrado después de la venta
        VentaMateriaPrima::actualizarStock($almacenFiltrado->materia_prima_filtrada, $request->cantidad);

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta actualizada con éxito');
    }

    /**
     * Elimina una venta existente.
     */
    public function destroy($id)
    {
        $venta = VentaMateriaPrima::findOrFail($id);

        // Recuperar la cantidad vendida y la materia prima asociada
        $cantidadVendida = $venta->cantidad;
        $materiaPrimaId = $venta->materia_prima_id;

        // Eliminar la venta
        $venta->delete();

        // Restaurar el stock en el almacen filtrado
        $almacenFiltrado = AlmacenFiltrado::where('materia_prima_filtrada', $materiaPrimaId)->first();
        if ($almacenFiltrado) {
            $almacenFiltrado->cantidad_materia_prima_filtrada += $cantidadVendida;
            $almacenFiltrado->save();
        }

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta eliminada con éxito');
    }
}
