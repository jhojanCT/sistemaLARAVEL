<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\VentaMateriaPrima;
use App\Models\VentaProducto;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Mostrar pagos agrupados por cuota
        $pagosPorCuota = $venta->pagos()->orderBy('cuota_numero')->get();
        return view('pagos.show', compact('venta', 'pagosPorCuota', 'type'));
    }

    // Agregar un pago a una venta
    public function store(Request $request, $id, $type)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'cuota_numero' => 'nullable|integer|min:1', // Validar el número de cuota
        ]);

        $venta = $this->getVentaByType($id, $type);

        if (!$venta) {
            return redirect()->route('pagos.index')->with('error', 'Venta no encontrada.');
        }

        if ($request->monto > $venta->saldo_deuda) {
            return redirect()->route('pagos.show', [$venta->id, $type])->with('error', 'El monto excede la deuda restante.');
        }

        // Registrar el nuevo pago dentro de una transacción para evitar inconsistencias
        DB::transaction(function () use ($venta, $request) {
            // Registrar el nuevo pago
            $pago = Pago::registrarPagoUnico($venta, $request->monto, $request->cuota_numero); 

            if (!$pago) {
                throw new \Exception('El pago ya ha sido registrado para esta cuota.');
            }

            // Actualizar saldo de la venta
            $this->updateVentaSaldo($venta);

            // Actualizar la cuenta asociada
            $this->updateCuenta($venta, $request->monto);
        });

        return redirect()->route('pagos.show', [$venta->id, $type])->with('success', 'Pago registrado correctamente.');
    }

    // Obtener la venta según el tipo (materia_prima o producto)
    private function getVentaByType($id, $type)
    {
        return $type === 'materia_prima' ? VentaMateriaPrima::find($id) : 
               ($type === 'producto' ? VentaProducto::find($id) : null);
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
            $cuenta->increment('saldo', $monto);
        }
    }
}
