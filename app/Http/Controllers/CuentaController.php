<?php

namespace App\Http\Controllers;

use App\Models\VentaMateriaPrima;
use App\Models\VentaProducto;
use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function index()
    {
        // Verificar si la cuenta "Bóveda" existe, si no, crearla automáticamente
        $boveda = Cuenta::firstOrCreate(['nombre' => 'Bóveda'], ['saldo' => 0]);

        // Obtener todas las cuentas excepto "Bóveda"
        $otrasCuentas = Cuenta::where('nombre', '!=', 'Bóveda')->get();

        // Calcular el saldo de "Bóveda" como la suma de los saldos de las demás cuentas
        $boveda->saldo = $otrasCuentas->sum('saldo');
        $boveda->save();

        return view('cuentas.index', [
            'cuentas' => Cuenta::all(), // Todas las cuentas incluyendo "Bóveda"
        ]);
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
        $cuenta = Cuenta::findOrFail($id);
        
        if ($cuenta->nombre == 'Bóveda') {
            // Si es la Bóveda, obtener todas las ventas
            $ventasMateriaPrima = VentaMateriaPrima::with(['pagos', 'materiaPrima', 'cliente'])->get();
            $ventasProducto = VentaProducto::with(['pagos', 'producto', 'cliente'])->get();
        } else {
            // Filtrar por cuenta_id
            $ventasMateriaPrima = VentaMateriaPrima::with(['pagos', 'materiaPrima', 'cliente'])
                ->where('cuenta_id', $id)
                ->get();
        
            $ventasProducto = VentaProducto::with(['pagos', 'producto', 'cliente'])
                ->where('cuenta_id', $id)
                ->get();
        }
    
        // Agregar dd() para depurar y ver las ventas
        //dd($ventasMateriaPrima, $ventasProducto); // Esto detendrá la ejecución y mostrará los datos de las ventas
    
        return view('cuentas.show', [
            'cuenta' => $cuenta,
            'ventasMateriaPrima' => $ventasMateriaPrima,
            'ventasProducto' => $ventasProducto,
            'totalMateriaPrima' => $ventasMateriaPrima->sum('precio_total'),
            'totalProductos' => $ventasProducto->sum('precio_total'),
            'cantidadMateriaPrima' => $ventasMateriaPrima->sum('cantidad'),
            'cantidadProductos' => $ventasProducto->sum('cantidad'),
        ]);
    }
    
    

    public function registrarPago(Request $request, $ventaId)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
        ]);

        $venta = VentaMateriaPrima::findOrFail($ventaId);

        if (!$venta->a_credito) {
            return redirect()->back()->with('error', 'La venta no es a crédito.');
        }

        if ($request->monto > $venta->saldo_deuda) {
            return redirect()->back()->with('error', 'El monto excede la deuda pendiente.');
        }

        $venta->decrement('saldo_deuda', $request->monto);

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
        if ($cuenta->nombre === 'Bóveda') {
            return redirect()->route('cuentas.index')->with('error', 'No puedes eliminar la cuenta Bóveda.');
        }

        $cuenta->delete();
        return redirect()->route('cuentas.index')->with('success', 'Cuenta eliminada con éxito.');
    }
}
