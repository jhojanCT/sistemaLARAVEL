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
            'cuota_inicial' => 'nullable|numeric|min:0',
            'saldo_deuda' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $producto = Producto::findOrFail($request->producto_id);

            if ($producto->stock < $request->cantidad) {
                throw new \Exception('No hay suficiente stock disponible.');
            }

            $precioTotal = $request->cantidad * $request->precio_unitario;
            $saldoDeuda = $request->a_credito ? ($precioTotal - $request->cuota_inicial) : 0;

            $venta = VentaProducto::create([
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'fecha_venta' => now(),
                'a_credito' => $request->a_credito,
                'cuota_inicial' => $request->cuota_inicial,
                'saldo_deuda' => $saldoDeuda,
            ]);

            if ($request->a_credito && $request->cuota_inicial > 0) {
                $this->realizarPagoInicial($venta, $request->cuota_inicial);
            }

            $producto->decrement('stock', $request->cantidad);

            if (!$request->a_credito) {
                $cuenta = Cuenta::findOrFail($request->cuenta_id);
                $cuenta->increment('saldo', $precioTotal);
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
            'cuota_inicial' => 'nullable|numeric|min:0',
            'saldo_deuda' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {
            $venta = VentaProducto::findOrFail($id);
            $producto = Producto::findOrFail($request->producto_id);

            if ($producto->stock < $request->cantidad) {
                throw new \Exception('No hay suficiente stock disponible.');
            }

            $precioTotal = $request->cantidad * $request->precio_unitario;
            $saldoDeuda = $request->a_credito ? ($precioTotal - $request->cuota_inicial) : 0;

            $venta->update([
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'precio_total' => $precioTotal,
                'cliente_id' => $request->cliente_id,
                'cuenta_id' => $request->cuenta_id,
                'a_credito' => $request->a_credito,
                'cuota_inicial' => $request->cuota_inicial,
                'saldo_deuda' => $saldoDeuda,
            ]);

            $producto->decrement('stock', $request->cantidad);

            if (!$request->a_credito) {
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

            $producto->increment('stock', $venta->cantidad);

            if (!$venta->a_credito) {
                $cuenta = Cuenta::findOrFail($venta->cuenta_id);
                $cuenta->decrement('saldo', $venta->precio_total);
            }

            $venta->delete();
        });

        return redirect()->route('ventas.productos.index')->with('success', 'Venta eliminada con éxito');
    }

    private function realizarPagoInicial($venta, $monto)
    {
        if ($monto > $venta->saldo_deuda) {
            throw new \Exception('El monto inicial excede el saldo de deuda.');
        }

        $venta->decrement('saldo_deuda', $monto);

        $cuenta = Cuenta::findOrFail($venta->cuenta_id);
        $cuenta->increment('saldo', $monto);
    }
}
