<?php

namespace App\Http\Controllers;

use App\Models\CreditoCompra;
use App\Models\ControlEntradaMateriaPrima;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CreditoCompraController extends Controller
{
    // Mostrar todos los créditos de compras
    public function index()
    {
        $creditos = CreditoCompra::with('controlEntradaMateriaPrima')->get()->unique('control_entrada_id');
        return view('credito_compras.index', compact('creditos'));
    }

    // Mostrar el formulario para crear un nuevo crédito de compra
    public function create()
    {
        $entradas = ControlEntradaMateriaPrima::all();
        $proveedores = Proveedor::all(); 
        return view('credito_compras.create', compact('entradas', 'proveedores'));
    }

    // Guardar un nuevo crédito de compra
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'monto_total' => 'required|numeric|min:0',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'control_entrada_id' => 'required|exists:control_entrada_materia_prima,id',
        ]);
        
        $entrada = ControlEntradaMateriaPrima::findOrFail($validated['control_entrada_id']);
        
        if ($entrada->creditoCompra) {
            return redirect()->route('credito_compras.index')
                             ->with('error', 'Ya existe un crédito de compra para esta entrada de materia prima.');
        }
        
        $credito = CreditoCompra::create([
            'control_entrada_id' => $entrada->id,
            'proveedor_id' => $validated['proveedor_id'],
            'monto_total' => $validated['monto_total'],
            'monto_pagado' => $validated['monto_pagado'],
            'fecha' => $validated['fecha'],
        ]);
        
        return redirect()->route('credito_compras.index')
                         ->with('success', 'Crédito de compra registrado correctamente.');
    }

    // Mostrar el formulario para editar un crédito de compra existente
    public function edit($id)
    {
        $credito = CreditoCompra::with(['controlEntradaMateriaPrima', 'proveedor'])->findOrFail($id);
        $entradas = ControlEntradaMateriaPrima::all();
        $proveedores = Proveedor::all();
        return view('credito_compras.edit', compact('credito', 'entradas', 'proveedores'));
    }

    // Actualizar un crédito de compra
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'monto_total' => 'required|numeric|min:0',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'control_entrada_id' => 'required|exists:control_entrada_materia_prima,id',
        ]);
    
        $credito = CreditoCompra::findOrFail($id);
    
        $credito->update([
            'control_entrada_id' => $validated['control_entrada_id'],
            'proveedor_id' => $validated['proveedor_id'],
            'monto_total' => $validated['monto_total'],
            'monto_pagado' => $validated['monto_pagado'],
            'fecha' => $validated['fecha'],
        ]);
    
        return redirect()->route('credito_compras.index')
                         ->with('success', 'Crédito de compra actualizado correctamente.');
    }

    // Mostrar los detalles de un crédito de compra
    public function show($id)
    {
        $credito = CreditoCompra::with(['controlEntradaMateriaPrima.materiaPrima', 'proveedor'])->findOrFail($id);
        return view('credito_compras.show', compact('credito'));
    }

    // Actualizar el pago de cuotas
    public function pay(Request $request, $id)
    {
        $validated = $request->validate([
            'monto_pagado' => 'required|numeric|min:0',
        ]);
    
        $credito = CreditoCompra::findOrFail($id);
        
        // Verifica que el pago no exceda lo que se debe
        if ($credito->monto_pagado + $validated['monto_pagado'] > $credito->monto_total) {
            return redirect()->route('credito_compras.show', $credito->id)
                             ->with('error', 'El monto pagado no puede exceder el monto total.');
        }
    
        // Actualiza el monto pagado
        $credito->monto_pagado += $validated['monto_pagado'];
        
        // Si el pago es igual al monto total, marca la compra como finalizada
        if ($credito->monto_pagado == $credito->monto_total) {
            $credito->estado = 'Finalizada';
        }
    
        // Registrar el pago en la tabla pagos_credito_compras
        $credito->pagos()->create([
            'monto_pagado' => $validated['monto_pagado'],
            'fecha_pago' => now(),  // Usamos la fecha actual como fecha de pago
        ]);
    
        $credito->save();
    
        return redirect()->route('credito_compras.show', $credito->id)
                         ->with('success', 'Pago registrado correctamente.');
    }
    

    // Eliminar un crédito de compra
    public function destroy($id)
    {
        $credito = CreditoCompra::findOrFail($id);
        $credito->delete();

        return redirect()->route('credito_compras.index')
                         ->with('success', 'Crédito de compra eliminado correctamente.');
    }
}
