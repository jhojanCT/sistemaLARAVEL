<?php

namespace App\Http\Controllers;

use App\Models\VentaMateriaPrima;
use App\Models\AlmacenFiltrado;
use App\Models\MateriaPrima;
use App\Models\Cliente;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'materia_prima_filtrada_id' => 'required|exists:almacen_filtrado,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',
        ]);

        DB::transaction(function () use ($request) {
            // Obtener el registro de materia prima filtrada
            $almacenFiltrado = AlmacenFiltrado::findOrFail($request->materia_prima_filtrada_id);

            // Verificar si hay suficiente stock disponible
            if ($almacenFiltrado->cantidad_materia_prima_filtrada < $request->cantidad) {
                throw new \Exception('No hay suficiente stock disponible.');
            }

            // Calcular el precio total
            $precioTotal = $request->cantidad * $request->precio_unitario;

            // Crear la venta
            $venta = VentaMateriaPrima::create([
                'materia_prima_id' => $almacenFiltrado->materia_prima_filtrada,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'fecha_venta' => now(),
            ]);

            // Actualizar el stock del almacen filtrado
            $almacenFiltrado->decrement('cantidad_materia_prima_filtrada', $request->cantidad);

            // Actualizar el saldo de la cuenta
            $cuenta = Cuenta::findOrFail($request->cuenta_id);
            $cuenta->increment('saldo', $precioTotal);
        });

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta registrada con éxito');
    }

    /**
     * Muestra el formulario para editar una venta existente.
     */
    public function edit($id)
    {
        $venta = VentaMateriaPrima::findOrFail($id);
        $materiasPrimas = AlmacenFiltrado::all();
        $clientes = Cliente::all();
        $cuentas = Cuenta::all();

        return view('ventas.materia_prima.edit', compact('venta', 'materiasPrimas', 'clientes', 'cuentas'));
    }

    /**
     * Actualiza una venta existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'materia_prima_filtrada_id' => 'required|exists:almacen_filtrado,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',
        ]);

        DB::transaction(function () use ($request, $id) {
            $venta = VentaMateriaPrima::findOrFail($id);

            // Obtener el registro de materia prima filtrada
            $almacenFiltrado = AlmacenFiltrado::findOrFail($request->materia_prima_filtrada_id);

            // Verificar si hay suficiente stock disponible
            if ($almacenFiltrado->cantidad_materia_prima_filtrada < $request->cantidad) {
                throw new \Exception('No hay suficiente stock disponible.');
            }

            // Calcular el precio total
            $precioTotal = $request->cantidad * $request->precio_unitario;

            // Actualizar la venta
            $venta->update([
                'materia_prima_id' => $almacenFiltrado->materia_prima_filtrada,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
            ]);

            // Actualizar el stock del almacen filtrado
            $almacenFiltrado->decrement('cantidad_materia_prima_filtrada', $request->cantidad);

            // Actualizar el saldo de la cuenta
            $cuenta = Cuenta::findOrFail($request->cuenta_id);
            $cuenta->increment('saldo', $precioTotal);
        });

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta actualizada con éxito');
    }

    /**
     * Elimina una venta existente.
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $venta = VentaMateriaPrima::findOrFail($id);

            // Restaurar el stock en el almacen filtrado
            $almacenFiltrado = AlmacenFiltrado::where('materia_prima_filtrada', $venta->materia_prima_id)->first();
            if ($almacenFiltrado) {
                $almacenFiltrado->increment('cantidad_materia_prima_filtrada', $venta->cantidad);
            }

            // Actualizar el saldo de la cuenta
            $cuenta = Cuenta::findOrFail($venta->cuenta_id);
            $cuenta->decrement('saldo', $venta->precio_total);

            // Eliminar la venta
            $venta->delete();
        });

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta eliminada con éxito');
    }
}