<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AperturaDiaria;
use Carbon\Carbon;

class AperturaDiariaController extends Controller
{
    public function abrirDia(Request $request)
    {
        $fechaHoy = Carbon::today();

        // Verificar si ya existe una apertura para hoy
        if (AperturaDiaria::where('fecha', $fechaHoy)->exists()) {
            return back()->with('error', 'El día ya fue abierto.');
        }

        // Crear apertura con el saldo inicial ingresado por el usuario
        $apertura = AperturaDiaria::create([
            'fecha' => $fechaHoy,
            'saldo_inicial' => $request->saldo_inicial
        ]);

        return redirect()->route('cierres.index')->with('success', 'Apertura del día registrada.');
    }

    public function index()
    {
        $aperturas = AperturaDiaria::all();
        return view('aperturas.index', compact('aperturas'));
    }
}
