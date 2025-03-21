<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CierreDiario;
use App\Models\AperturaDiaria;
use App\Models\VentaMateriaPrima;
use App\Models\VentaProducto;
use App\Models\Pago;
use Carbon\Carbon;
use App\Models\ControlEntradaMateriaPrima;

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
    
        // Obtener ventas, pagos y compras del día
        $ventasMateriaPrima = VentaMateriaPrima::whereDate('created_at', $fechaHoy)->get();
        $ventasProducto = VentaProducto::whereDate('created_at', $fechaHoy)->get();
        $pagos = Pago::whereDate('created_at', $fechaHoy)->get();
        $comprasMateriaPrima = ControlEntradaMateriaPrima::whereDate('created_at', $fechaHoy)->get();
    
        // Calcular totales
        $totalVentasMateriaPrima = $ventasMateriaPrima->sum('precio_total');
        $totalVentasProducto = $ventasProducto->sum('precio_total');
        $totalPagos = $pagos->sum('monto');
        $totalComprasMateriaPrima = $comprasMateriaPrima->sum('precio_total'); // SUMAR COMPRAS

        $saldoInicial = $apertura->saldo_inicial;
    
        // Calcular saldo final considerando las compras
        $saldoFinal = $apertura->saldo_inicial + $totalVentasMateriaPrima + $totalVentasProducto - $totalPagos - $totalComprasMateriaPrima;
    
        // Guardar el cierre del día
        $cierre = CierreDiario::create([
            'fecha' => $fechaHoy,
            'total_ventas_materia_prima' => $totalVentasMateriaPrima,
            'total_ventas_producto' => $totalVentasProducto,
            'total_compras_materia_prima' => $totalComprasMateriaPrima,
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
    
        // Obtener ventas de materia prima relacionadas
        $ventasMateriaPrima = VentaMateriaPrima::whereDate('created_at', $cierre->fecha)->get();
    
        // Obtener ventas de productos relacionadas
        $ventasProducto = VentaProducto::whereDate('created_at', $cierre->fecha)->get();
    
        // Obtener compras de materia prima relacionadas
        $comprasMateriaPrima = ControlEntradaMateriaPrima::whereDate('created_at', $cierre->fecha)->get();
    
        // Obtener pagos relacionados
        $pagos = Pago::whereDate('created_at', $cierre->fecha)->get();
    
        return view('cierres.show', compact('cierre', 'ventasMateriaPrima', 'ventasProducto', 'comprasMateriaPrima', 'pagos'));
    }
    
}
