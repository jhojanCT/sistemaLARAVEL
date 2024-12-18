<?php

namespace App\Http\Controllers;

use App\Models\AlmacenFiltrado;

class AlmacenFiltradoController extends Controller
{
    /**
     * Muestra el listado de Almacen Filtrado.
     */
    public function index()
    {
        $almacenFiltrado = AlmacenFiltrado::with('proveedor')->get();

        return view('almacen_filtrado.index', compact('almacenFiltrado'));
    }
}
