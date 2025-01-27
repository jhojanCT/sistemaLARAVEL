<?php

namespace App\Http\Controllers;

use App\Models\VentaMateriaPrima;
use App\Models\AlmacenFiltrado;
use App\Models\MateriaPrima;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaMateriaPrimaController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::all();
        $ventas = VentaMateriaPrima::with(['materiaPrima', 'cliente', 'cuenta'])->get();
        return view('ventas.materia_prima.index', compact('ventas', 'cuentas'));
    }

    public function create()
    {
        $materiasPrimas = AlmacenFiltrado::all();
        $clientes = Cliente::all();
        $cuentas = Cuenta::all();
        return view('ventas.materia_prima.create', compact('materiasPrimas', 'clientes', 'cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia_prima_filtrada_id' => 'required|exists:almacen_filtrado,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',
            'a_credito' => 'required|boolean',
            'encargado' => 'required|string|max:255', // Validación para el encargado
        ]);

        DB::transaction(function () use ($request) {
            $almacenFiltrado = AlmacenFiltrado::findOrFail($request->materia_prima_filtrada_id);

            if ($almacenFiltrado->cantidad_materia_prima_filtrada < $request->cantidad) {
                throw new \Exception('No hay suficiente stock disponible.');
            }

            $precioTotal = $request->cantidad * $request->precio_unitario;
            $saldoDeuda = $request->a_credito ? $precioTotal : 0;

            $venta = VentaMateriaPrima::create([
                'materia_prima_id' => $almacenFiltrado->materia_prima_filtrada,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'fecha_venta' => now(),
                'a_credito' => $request->a_credito,
                'saldo_deuda' => $saldoDeuda,
                'encargado' => $request->encargado, // Agregar encargado
            ]);

            $almacenFiltrado->decrement('cantidad_materia_prima_filtrada', $request->cantidad);

            // Si la venta es a crédito, no se realiza el pago inmediatamente
            if ($request->a_credito) {
                // No se mueve dinero, solo se registra el saldo de deuda
                // Puedes crear un pago inicial con saldo de deuda
                Pago::create([
                    'venta_id' => $venta->id,
                    'monto' => $saldoDeuda,
                    'venta_type' => 'VentaMateriaPrima',
                    'fecha_pago' => now(),
                ]);
            } else {
                // Si la venta no es a crédito, se mueve el dinero a la cuenta directamente
                $cuenta = Cuenta::findOrFail($request->cuenta_id);
                $cuenta->increment('saldo', $precioTotal);
            }
        });

        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta registrada con éxito');
    }

    public function edit($id)
    {
        $venta = VentaMateriaPrima::findOrFail($id);
        $materiasPrimas = AlmacenFiltrado::all();
        $clientes = Cliente::all();
        $cuentas = Cuenta::all();
        return view('ventas.materia_prima.edit', compact('venta', 'materiasPrimas', 'clientes', 'cuentas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materia_prima_filtrada_id' => 'required|exists:almacen_filtrado,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',
            'a_credito' => 'required|boolean',
            'encargado' => 'required|string|max:255', // Validación para el encargado
        ]);
    
        DB::transaction(function () use ($request, $id) {
            $venta = VentaMateriaPrima::findOrFail($id);
            $almacenFiltrado = AlmacenFiltrado::findOrFail($request->materia_prima_filtrada_id);
    
            // Verificar si la cantidad de la venta ha cambiado
            $cantidadAnterior = $venta->cantidad;
            $nuevaCantidad = $request->cantidad;
    
            // Si la cantidad ha cambiado, ajustamos el stock
            if ($cantidadAnterior != $nuevaCantidad) {
                // Si la nueva cantidad es mayor, restamos la diferencia del stock
                if ($nuevaCantidad > $cantidadAnterior) {
                    if ($almacenFiltrado->cantidad_materia_prima_filtrada < ($nuevaCantidad - $cantidadAnterior)) {
                        throw new \Exception('No hay suficiente stock disponible.');
                    }
                    $almacenFiltrado->decrement('cantidad_materia_prima_filtrada', $nuevaCantidad - $cantidadAnterior);
                } 
                // Si la nueva cantidad es menor, devolvemos la diferencia al stock
                else {
                    $almacenFiltrado->increment('cantidad_materia_prima_filtrada', $cantidadAnterior - $nuevaCantidad);
                }
            }
    
            // Calcular el precio total y saldo de deuda
            $precioTotal = $nuevaCantidad * $request->precio_unitario;
            $saldoDeuda = $request->a_credito ? $precioTotal : 0;
    
            // Actualizar la venta
            $venta->update([
                'materia_prima_id' => $almacenFiltrado->materia_prima_filtrada,
                'cantidad' => $nuevaCantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'a_credito' => $request->a_credito,
                'saldo_deuda' => $saldoDeuda,
                'encargado' => $request->encargado, // Actualizar encargado
            ]);
    
            // Si la venta es a crédito, actualizamos el pago
            if ($request->a_credito) {
                Pago::updateOrCreate(
                    ['venta_id' => $venta->id],
                    ['monto' => $saldoDeuda, 'venta_type' => 'VentaMateriaPrima', 'fecha_pago' => now()]
                );
            } else {
                // Si la venta no es a crédito, actualizamos la cuenta correspondiente
                $cuenta = Cuenta::findOrFail($request->cuenta_id);
                $cuenta->increment('saldo', $precioTotal);
            }
        });
    
        return redirect()->route('ventas.materia_prima.index')->with('success', 'Venta actualizada con éxito');
    }
}
