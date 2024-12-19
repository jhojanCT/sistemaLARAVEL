<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlmacenSinFiltro;

class AlmacenSinFiltroController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla almacen_sin_filtro
        $almacenSinFiltro = AlmacenSinFiltro::with('proveedor')->get();

        // Pasar los datos a la vista
        return view('almacen_sin_filtro.index', compact('almacenSinFiltro'));
    }
}
