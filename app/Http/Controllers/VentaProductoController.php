<?php

namespace App\Http\Controllers;

use App\Models\VentaProducto;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Cuenta;  // Importa el modelo de Cuenta
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VentaProductoController extends Controller
{
    public function index()
    {
        $ventas = VentaProducto::with(['producto', 'cliente'])->get();
        return view('ventas.productos.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        $cuentas = Cuenta::all();  // Obtiene todas las cuentas disponibles
        return view('ventas.productos.create', compact('productos', 'clientes', 'cuentas'));
    }

    public function store(Request $request)
    {
        // Validar los datos de la venta
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id',
            'cuenta_id' => 'required|exists:cuentas,id',  // Validar la cuenta seleccionada
        ]);

        // Obtener el producto
        $producto = Producto::find($validated['producto_id']);
        $cuenta = Cuenta::find($validated['cuenta_id']);  // Obtener la cuenta seleccionada

        // Verificar si hay suficiente cantidad en stock
        if ($producto->cantidad < $validated['cantidad']) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible para este producto.');
        }

        // Iniciar una transacción para realizar la venta y actualizar el stock
        DB::beginTransaction();

        try {
            // Calcular el precio total de la venta
            $precioTotal = $validated['cantidad'] * $validated['precio_unitario'];

            // Crear la venta de producto
            VentaProducto::create([
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad'],
                'precio_unitario' => $validated['precio_unitario'],
                'precio_total' => $precioTotal,
                'cliente_id' => $validated['cliente_id'],
                'cuenta_id' => $validated['cuenta_id'],  // Asociar la cuenta con la venta
                'fecha_venta' => now(),
            ]);

            // Reducir la cantidad de producto en el inventario
            $producto->cantidad -= $validated['cantidad'];
            $producto->save();

            // Actualizar el saldo de la cuenta
            $cuenta->saldo += $precioTotal;  // Actualiza el saldo con el monto de la venta
            $cuenta->save();

            // Confirmar la transacción
            DB::commit();

            // Redirigir con mensaje de éxito
            return redirect()->route('ventas.productos.index')->with('success', 'Venta registrada y stock actualizado con éxito.');
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la venta.');
        }
    }

    public function edit($id)
    {
        try {
            $venta = VentaProducto::findOrFail($id);
            $productos = Producto::all();
            $clientes = Cliente::all();
            $cuentas = Cuenta::all();  // Obtener las cuentas disponibles
            return view('ventas.productos.edit', compact('venta', 'productos', 'clientes', 'cuentas'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('ventas.productos.index')->with('error', 'Venta no encontrada.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validar los datos de la actualización
            $validated = $request->validate([
                'producto_id' => 'required|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
                'precio_unitario' => 'required|numeric|min:0',
                'cliente_id' => 'required|exists:clientes,id',
                'cuenta_id' => 'required|exists:cuentas,id',  // Validar la cuenta seleccionada
            ]);

            // Obtener la venta
            $venta = VentaProducto::findOrFail($id);
            $producto = Producto::find($validated['producto_id']);
            $cuenta = Cuenta::find($validated['cuenta_id']);  // Obtener la cuenta seleccionada

            // Verificar si la cantidad solicitada está disponible
            if ($producto->cantidad < $validated['cantidad']) {
                return redirect()->back()->with('error', 'No hay suficiente stock disponible para este producto.');
            }

            // Iniciar la transacción para actualizar la venta y el stock
            DB::beginTransaction();

            // Calcular el nuevo precio total
            $precioTotal = $validated['cantidad'] * $validated['precio_unitario'];

            // Actualizar la venta de producto
            $venta->update([
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad'],
                'precio_unitario' => $validated['precio_unitario'],
                'precio_total' => $precioTotal,
                'cliente_id' => $validated['cliente_id'],
                'cuenta_id' => $validated['cuenta_id'],  // Actualizar la cuenta asociada
            ]);

            // Actualizar la cantidad de producto en stock
            $producto->cantidad -= $validated['cantidad'];
            $producto->save();

            // Actualizar el saldo de la cuenta
            $cuenta->saldo += $precioTotal;  // Actualiza el saldo con el monto de la venta
            $cuenta->save();

            // Confirmar la transacción
            DB::commit();

            // Redirigir con mensaje de éxito
            return redirect()->route('ventas.productos.index')->with('success', 'Venta actualizada y stock actualizado con éxito.');
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la venta.');
        }
    }

    public function destroy($id)
    {
        try {
            $venta = VentaProducto::findOrFail($id);
            $producto = $venta->producto;
            $cuenta = $venta->cuenta;  // Obtener la cuenta asociada a la venta

            // Iniciar transacción para eliminar la venta y restaurar stock
            DB::beginTransaction();

            // Restaurar el stock del producto
            $producto->cantidad += $venta->cantidad;
            $producto->save();

            // Restaurar el saldo de la cuenta
            $cuenta->saldo -= $venta->precio_total;  // Restar el monto de la venta del saldo
            $cuenta->save();

            // Eliminar la venta
            $venta->delete();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('ventas.productos.index')->with('success', 'Venta eliminada y stock restaurado con éxito.');
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la venta.');
        }
    }
}
