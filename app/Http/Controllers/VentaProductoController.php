<?php

namespace App\Http\Controllers;

use App\Models\VentaProducto;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaProductoController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::all();
        $ventas = VentaProducto::with(['producto', 'cliente', 'cuenta'])->get();
        return view('ventas.productos.index', compact('ventas', 'cuentas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        $cuentas = Cuenta::all();
        return view('ventas.productos.create', compact('productos', 'clientes', 'cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',
            'a_credito' => 'required|boolean',
            'encargado' => 'required|string|max:255', // Validación para el encargado
        ]);

        DB::transaction(function () use ($request) {
            $producto = Producto::findOrFail($request->producto_id);

            if ($producto->cantidad < $request->cantidad) {
                throw new \Exception('No hay suficiente cantidad disponible.');
            }

            $precioTotal = $request->cantidad * $request->precio_unitario;
            $saldoDeuda = $request->a_credito ? $precioTotal : 0;

            $venta = VentaProducto::create([
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'fecha_venta' => now(),
                'a_credito' => $request->a_credito,
                'saldo_deuda' => $saldoDeuda,
                'encargado' => $request->encargado, // Guardar el encargado
            ]);

            $producto->decrement('cantidad', $request->cantidad);

            if (!$request->a_credito) {
                $cuenta = Cuenta::findOrFail($request->cuenta_id);
                $cuenta->increment('saldo', $precioTotal);
            } else {
                // Crear pago inicial si es a crédito
                Pago::create([
                    'venta_id' => $venta->id,
                    'monto' => $saldoDeuda,
                    'venta_type' => 'VentaProducto',
                    'fecha_pago' => now(),
                ]);
            }
        });

        return redirect()->route('ventas.productos.index')->with('success', 'Venta registrada con éxito');
    }

    public function edit($id)
    {
        $venta = VentaProducto::findOrFail($id);
        $productos = Producto::all();
        $clientes = Cliente::all();
        $cuentas = Cuenta::all();
        return view('ventas.productos.edit', compact('venta', 'productos', 'clientes', 'cuentas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',
            'a_credito' => 'required|boolean',
            'encargado' => 'required|string|max:255', // Validación para el encargado
        ]);

        DB::transaction(function () use ($request, $id) {
            $venta = VentaProducto::findOrFail($id);
            $producto = Producto::findOrFail($request->producto_id);

            // Verificar si la cantidad de la venta ha cambiado
            $cantidadAnterior = $venta->cantidad;
            $nuevaCantidad = $request->cantidad;

            // Si la cantidad ha cambiado, ajustamos el stock
            if ($cantidadAnterior != $nuevaCantidad) {
                // Si la nueva cantidad es mayor, restamos la diferencia del stock
                if ($nuevaCantidad > $cantidadAnterior) {
                    if ($producto->cantidad < ($nuevaCantidad - $cantidadAnterior)) {
                        throw new \Exception('No hay suficiente cantidad disponible.');
                    }
                    $producto->decrement('cantidad', $nuevaCantidad - $cantidadAnterior);
                }
                // Si la nueva cantidad es menor, devolvemos la diferencia al stock
                else {
                    $producto->increment('cantidad', $cantidadAnterior - $nuevaCantidad);
                }
            }

            // Calcular el precio total y saldo de deuda
            $precioTotal = $nuevaCantidad * $request->precio_unitario;
            $saldoDeuda = $request->a_credito ? $precioTotal : 0;

            // Actualizar la venta
            $venta->update([
                'producto_id' => $producto->id,
                'cantidad' => $nuevaCantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'a_credito' => $request->a_credito,
                'saldo_deuda' => $saldoDeuda,
                'encargado' => $request->encargado, // Actualizar el encargado
            ]);

            // Si la venta es a crédito, actualizamos el pago
            if ($request->a_credito) {
                Pago::updateOrCreate(
                    ['venta_id' => $venta->id],
                    ['monto' => $saldoDeuda, 'venta_type' => 'VentaProducto', 'fecha_pago' => now()]
                );
            } else {
                // Si la venta no es a crédito, actualizamos la cuenta correspondiente
                $cuenta = Cuenta::findOrFail($request->cuenta_id);
                $cuenta->increment('saldo', $precioTotal);
            }
        });

        return redirect()->route('ventas.productos.index')->with('success', 'Venta actualizada con éxito');
    }

    public function realizarPago(Request $request, $ventaId)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request, $ventaId) {
            $venta = VentaProducto::findOrFail($ventaId);

            if (!$venta->a_credito) {
                throw new \Exception('No puedes realizar pagos a una venta que no es a crédito.');
            }

            if ($request->monto > $venta->saldo_deuda) {
                throw new \Exception('El monto excede el saldo de deuda.');
            }

            $venta->decrement('saldo_deuda', $request->monto);

            $cuenta = Cuenta::findOrFail($venta->cuenta_id);
            $cuenta->increment('saldo', $request->monto);
        });

        return redirect()->route('ventas.productos.index')->with('success', 'Pago registrado con éxito.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $venta = VentaProducto::findOrFail($id);
            $producto = Producto::findOrFail($venta->producto_id);

            $producto->increment('cantidad', $venta->cantidad);

            if (!$venta->a_credito) {
                $cuenta = Cuenta::findOrFail($venta->cuenta_id);
                $cuenta->decrement('saldo', $venta->precio_total);
            }

            $venta->delete();
        });

        return redirect()->route('ventas.productos.index')->with('success', 'Venta eliminada con éxito');
    }
}
