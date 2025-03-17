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

        // Obtener las ventas y pagos del día
        $ventasMateriaPrima = VentaMateriaPrima::whereDate('created_at', $fechaHoy)->get();
        $ventasProducto = VentaProducto::whereDate('created_at', $fechaHoy)->get();
        $pagos = Pago::whereDate('created_at', $fechaHoy)->get();

        // Calcular totales
        $totalVentasMateriaPrima = $ventasMateriaPrima->sum('precio_total');
        $totalVentasProducto = $ventasProducto->sum('precio_total');
        $totalPagos = $pagos->sum('monto');

        // Calcular saldo final
        $saldoFinal = $apertura->saldo_inicial + $totalVentasMateriaPrima + $totalVentasProducto - $totalPagos;

        // Guardar el cierre del día
        $cierre = CierreDiario::create([
            'fecha' => $fechaHoy,
            'total_ventas_materia_prima' => $totalVentasMateriaPrima,
            'total_ventas_producto' => $totalVentasProducto,
            'total_pagos' => $totalPagos,
            'saldo_final' => $saldoFinal,
        ]);

        return redirect()->route('cierres.show', $cierre->id)->with('success', 'Cierre diario realizado.');
    }

    public function index()
    {
        $cierres = CierreDiario::all();
        return view('cierres.index', compact('cierres'));
    }

    public function show($id)
    {
        $cierre = CierreDiario::findOrFail($id);
        
        // Obtener la apertura correspondiente a esta fecha
        $apertura = AperturaDiaria::where('fecha', $cierre->fecha)->first();

        // Obtener ventas y pagos del día
        $ventasMateriaPrima = VentaMateriaPrima::whereDate('created_at', $cierre->fecha)->get();
        $ventasProducto = VentaProducto::whereDate('created_at', $cierre->fecha)->get();
        $pagos = Pago::whereDate('created_at', $cierre->fecha)->get();

        return view('cierres.show', compact('cierre', 'apertura', 'ventasMateriaPrima', 'ventasProducto', 'pagos'));
    }
}
