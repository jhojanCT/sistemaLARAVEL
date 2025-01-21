<?php

namespace App\Http\Controllers;

use App\Models\VentaMateriaPrima;
use App\Models\VentaProducto;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentaController extends Controller
{
    public function index()
    {
        // Obtener todas las cuentas
        $cuentas = Cuenta::all();

        // Calcular el total de los saldos de todas las cuentas
        $totalSaldo = $cuentas->sum('saldo');

        return view('cuentas.index', compact('cuentas', 'totalSaldo'));
    }

    public function create()
    {
        return view('cuentas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:cuentas|max:255',
            'saldo' => 'nullable|numeric|min:0',
        ]);

        Cuenta::create([
            'nombre' => $request->nombre,
            'saldo' => $request->saldo ?? 0,
        ]);

        return redirect()->route('cuentas.index')->with('success', 'Cuenta creada con éxito.');
    }

    public function show($id)
    {
        // Obtener la cuenta específica
        $cuenta = Cuenta::findOrFail($id);

        if ($cuenta->nombre == 'Cuenta General') {
            // Mostrar todas las ventas
            $ventasMateriaPrima = VentaMateriaPrima::all();
            $ventasProducto = VentaProducto::all();
        } else {
            // Mostrar ventas específicas de la cuenta
            $ventasMateriaPrima = VentaMateriaPrima::where('cuenta_id', $id)->get();
            $ventasProducto = VentaProducto::where('cuenta_id', $id)->get();
        }

        // Calcular totales
        $totalMateriaPrima = $ventasMateriaPrima->sum('precio_total');
        $totalProductos = $ventasProducto->sum('precio_total');

        // Calcular cantidad total
        $cantidadMateriaPrima = $ventasMateriaPrima->sum('cantidad');
        $cantidadProductos = $ventasProducto->sum('cantidad');

        return view('cuentas.show', compact(
            'cuenta',
            'ventasMateriaPrima',
            'ventasProducto',
            'totalMateriaPrima',
            'totalProductos',
            'cantidadMateriaPrima',
            'cantidadProductos'
        ));
    }

    public function registrarPago(Request $request, $ventaId)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
        ]);

        // Buscar la venta
        $venta = VentaMateriaPrima::findOrFail($ventaId);

        // Verificar que la venta es a crédito
        if (!$venta->a_credito) {
            return redirect()->back()->with('error', 'La venta no es a crédito.');
        }

        // Verificar que el monto no exceda la deuda pendiente
        if ($request->monto > $venta->saldo_deuda) {
            return redirect()->back()->with('error', 'El monto excede la deuda pendiente.');
        }

        // Actualizar el saldo de deuda
        $venta->decrement('saldo_deuda', $request->monto);

        // Actualizar el saldo de la cuenta asociada
        $cuenta = $venta->cuenta;
        $cuenta->increment('saldo', $request->monto);

        return redirect()->route('cuentas.show', $cuenta->id)->with('success', 'Pago registrado con éxito.');
    }

    public function edit(Cuenta $cuenta)
    {
        return view('cuentas.edit', compact('cuenta'));
    }

    public function update(Request $request, Cuenta $cuenta)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:cuentas,nombre,' . $cuenta->id,
            'saldo' => 'nullable|numeric|min:0',
        ]);

        $cuenta->update($request->all());

        return redirect()->route('cuentas.index')->with('success', 'Cuenta actualizada con éxito.');
    }

    public function destroy(Cuenta $cuenta)
    {
        if ($cuenta->nombre === 'Cuenta General') {
            return redirect()->route('cuentas.index')->with('error', 'No puedes eliminar la Cuenta General.');
        }

        $cuenta->delete();
        return redirect()->route('cuentas.index')->with('success', 'Cuenta eliminada con éxito.');
    }
}
