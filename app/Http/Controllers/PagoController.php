<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\VentaMateriaPrima;
use App\Models\VentaProducto;
use App\Models\Cuenta;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    // Mostrar los pagos de las ventas a crédito
    public function index()
    {
        $ventasMateriaPrima = VentaMateriaPrima::where('saldo_deuda', '>', 0)->with('pagos')->get();
        $ventasProducto = VentaProducto::where('saldo_deuda', '>', 0)->with('pagos')->get();

        return view('pagos.index', compact('ventasMateriaPrima', 'ventasProducto'));
    }

    // Mostrar los detalles de una venta y sus pagos
    public function show($id, $type)
    {
        $venta = $this->getVentaByType($id, $type);

        if (!$venta) {
            return redirect()->route('pagos.index')->with('error', 'Venta no encontrada.');
        }

        $pagos = $venta->pagos;
        return view('pagos.show', compact('venta', 'pagos', 'type'));
    }

    // Agregar un pago a una venta
    public function store(Request $request, $id, $type)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
        ]);

        $venta = $this->getVentaByType($id, $type);

        if (!$venta) {
            return redirect()->route('pagos.index')->with('error', 'Venta no encontrada.');
        }

        if ($request->monto > $venta->saldo_deuda) {
            return redirect()->route('pagos.show', [$venta->id, $type])->with('error', 'El monto excede la deuda restante.');
        }

        // Registrar el nuevo pago
        $pago = new Pago();
        $pago->monto = $request->monto;
        $pago->venta_id = $venta->id;
        $pago->venta_type = get_class($venta);
        $pago->save();

        // Actualizar saldo de la venta
        $this->updateVentaSaldo($venta);

        // Actualizar la cuenta asociada
        $this->updateCuenta($venta, $request->monto);

        return redirect()->route('pagos.show', [$venta->id, $type])->with('success', 'Pago registrado correctamente.');
    }

    // Obtener la venta según el tipo (materia_prima o producto)
    private function getVentaByType($id, $type)
    {
        if ($type === 'materia_prima') {
            return VentaMateriaPrima::find($id);
        } elseif ($type === 'producto') {
            return VentaProducto::find($id);
        }

        return null;
    }

    // Actualizar el saldo de la venta después de un pago
    private function updateVentaSaldo($venta)
    {
        $totalPagado = $venta->pagos()->sum('monto');
        $venta->saldo_deuda = $venta->precio_total - $totalPagado;

        // Cambiar el estado a finalizado si el saldo llega a 0
        if ($venta->saldo_deuda <= 0) {
            $venta->estado = 'finalizado';
        }

        $venta->save();
    }

    // Actualizar el saldo de la cuenta asociada
    private function updateCuenta($venta, $monto)
    {
        $cuenta = Cuenta::find($venta->cuenta_id);

        if ($cuenta) {
            $cuenta->saldo += $monto;
            $cuenta->save();
        }
    }
}
