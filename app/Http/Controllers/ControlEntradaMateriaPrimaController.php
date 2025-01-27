<?php

namespace App\Http\Controllers;

use App\Models\ControlEntradaMateriaPrima;
use App\Models\CreditoCompra;
use App\Models\Proveedor;
use App\Models\MateriaPrima;
use App\Models\AlmacenSinFiltro;
use Illuminate\Http\Request;

class ControlEntradaMateriaPrimaController extends Controller
{
    // Mostrar todas las entradas de materia prima
    public function index()
    {
        $entradas = ControlEntradaMateriaPrima::with('proveedor', 'materiaPrima', 'creditoCompra')->get();
        return view('control_entrada_materia_prima.index', compact('entradas'));
    }

    // Mostrar el formulario para crear una nueva entrada de materia prima
    public function create()
    {
        $proveedores = Proveedor::all();
        $materiasPrimas = MateriaPrima::all();
        return view('control_entrada_materia_prima.create', compact('proveedores', 'materiasPrimas'));
    }

    // Guardar una nueva entrada de materia prima
    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'materia_prima_id' => 'required|exists:materias_primas,id',
            'cantidad' => 'required|numeric',
            'encargado' => 'required|string',
            'fecha_llegada' => 'required|date',
            'precio_unitario_por_kilo' => 'required|numeric|min:0',
            'compra_credito' => 'required|boolean', // Solo "Sí" o "No"
        ]);

        // Crear o encontrar el almacén sin filtro
        $almacenSinFiltro = AlmacenSinFiltro::firstOrCreate([
            'proveedor_id' => $validated['proveedor_id'],
            'materia_prima_id' => $validated['materia_prima_id'],
        ]);

        // Calcular el precio total
        $precioTotal = $validated['cantidad'] * $validated['precio_unitario_por_kilo'];

        // Crear la entrada en ControlEntradaMateriaPrima
        $entrada = ControlEntradaMateriaPrima::create([
            'proveedor_id' => $validated['proveedor_id'],
            'materia_prima_id' => $validated['materia_prima_id'],
            'cantidad' => $validated['cantidad'],
            'encargado' => $validated['encargado'],
            'fecha_llegada' => $validated['fecha_llegada'],
            'almacen_sin_filtro_id' => $almacenSinFiltro->id,
            'precio_unitario_por_kilo' => $validated['precio_unitario_por_kilo'],
            'precio_total' => $precioTotal,
            'compra_credito' => $validated['compra_credito'],
        ]);

        // Si la compra es a crédito, se crea un registro en CreditoCompra
        if ($validated['compra_credito']) {
            CreditoCompra::create([
                'control_entrada_id' => $entrada->id,
                'proveedor_id' => $validated['proveedor_id'], // Asegúrate de que este campo esté presente
                'monto_total' => $precioTotal,  // El monto total de la compra
                'monto_pagado' => 0,  // El monto pagado es 0 al principio
                'fecha' => now(),  // Fecha actual
            ]);
        }

        // Actualizar la cantidad total en el AlmacenSinFiltro
        $almacenSinFiltro->cantidad_total += $entrada->cantidad;
        $almacenSinFiltro->save();

        return redirect()->route('control_entrada_materia_prima.index')
                         ->with('success', 'Entrada de Materia Prima creada correctamente.');
    }

    // Mostrar el formulario para editar una entrada de materia prima
    public function edit($id)
    {
        $entrada = ControlEntradaMateriaPrima::with('creditoCompra')->findOrFail($id);
        $proveedores = Proveedor::all();
        $materiasPrimas = MateriaPrima::all();
        return view('control_entrada_materia_prima.edit', compact('entrada', 'proveedores', 'materiasPrimas'));
    }

    // Actualizar una entrada de materia prima
    public function update(Request $request, $id)
    {
        // Validar los datos
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'materia_prima_id' => 'required|exists:materias_primas,id',
            'cantidad' => 'required|numeric',
            'encargado' => 'required|string',
            'fecha_llegada' => 'required|date',
            'precio_unitario_por_kilo' => 'required|numeric|min:0',
            'compra_credito' => 'required|boolean',  // Solo "Sí" o "No"
        ]);

        // Buscar la entrada existente
        $entrada = ControlEntradaMateriaPrima::findOrFail($id);
        $cantidadAnterior = $entrada->cantidad;

        // Actualizar la entrada
        $entrada->update([
            'proveedor_id' => $validated['proveedor_id'],
            'materia_prima_id' => $validated['materia_prima_id'],
            'cantidad' => $validated['cantidad'],
            'encargado' => $validated['encargado'],
            'fecha_llegada' => $validated['fecha_llegada'],
            'precio_unitario_por_kilo' => $validated['precio_unitario_por_kilo'],
            'precio_total' => $validated['cantidad'] * $validated['precio_unitario_por_kilo'],
            'compra_credito' => $validated['compra_credito'],
        ]);

        // Si la compra es a crédito, actualizar o crear el registro en CreditoCompra
        if ($validated['compra_credito']) {
            if ($entrada->creditoCompra) {
                $entrada->creditoCompra->update([
                    'monto_total' => $entrada->precio_total,  // El monto total actualizado
                    'monto_pagado' => 0,  // El monto pagado es 0 al principio
                    'fecha' => now(),  // Fecha de la compra
                ]);
            } else {
                CreditoCompra::create([
                    'control_entrada_id' => $entrada->id,
                    'proveedor_id' => $validated['proveedor_id'], // Asegúrate de que este campo esté presente
                    'monto_total' => $entrada->precio_total,
                    'monto_pagado' => 0,
                    'fecha' => now(),
                ]);
            }
        } else {
            // Si la compra no es a crédito, eliminar el registro de crédito (si existe)
            if ($entrada->creditoCompra) {
                $entrada->creditoCompra->delete();
            }
        }

        // Buscar el registro en el almacén
        $almacen = AlmacenSinFiltro::where('proveedor_id', $entrada->proveedor_id)
                                   ->where('materia_prima_id', $entrada->materia_prima_id)
                                   ->first();

        if ($almacen) {
            // Restar la cantidad anterior y sumar la nueva cantidad
            $almacen->cantidad_total = $almacen->cantidad_total - $cantidadAnterior + $validated['cantidad'];
            $almacen->save();
        }

        return redirect()->route('control_entrada_materia_prima.index')
                         ->with('success', 'Entrada de Materia Prima actualizada correctamente.');
    }
}
