<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CierreDiario;
use App\Models\AperturaDiaria;
use App\Models\VentaMateriaPrima;
use App\Models\VentaProducto;
use App\Models\Pago;
use Carbon\Carbon;

class CierreDiarioController extends Controller
{
    public function cerrarDia()
    {
        $fechaHoy = Carbon::today();

        // Verificar si hay una apertura para hoy
        $apertura = AperturaDiaria::where('fecha', $fechaHoy)->first();
        if (!$apertura) {
            return back()->with('error', 'Debe realizar la apertura antes de cerrar el día.');
        }

        // Obtener el total de ventas y pagos del día
        $totalVentasMateriaPrima = VentaMateriaPrima::whereDate('created_at', $fechaHoy)->sum('precio_total');
        $totalVentasProducto = VentaProducto::whereDate('created_at', $fechaHoy)->sum('precio_total');
        $totalPagos = Pago::whereDate('created_at', $fechaHoy)->sum('monto');

        // Calcular el saldo final
        $saldoFinal = $apertura->saldo_inicial + $totalVentasMateriaPrima + $totalVentasProducto - $totalPagos;

        // Guardar el cierre del día
        CierreDiario::create([
            'fecha' => $fechaHoy,
            'total_ventas_materia_prima' => $totalVentasMateriaPrima,
            'total_ventas_producto' => $totalVentasProducto,
            'total_pagos' => $totalPagos,
            'saldo_final' => $saldoFinal,
        ]);

        return redirect()->route('cierres.index')->with('success', 'Cierre diario realizado.');
    }

    public function index()
    {
        $cierres = CierreDiario::all();
        return view('cierres.index', compact('cierres'));
    }
}
