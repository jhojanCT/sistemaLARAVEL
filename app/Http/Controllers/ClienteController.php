<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        // Retornar la vista con la lista de clientes
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        // Retornar la vista para crear un nuevo cliente
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'nullable|email|unique:clientes',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // Crear el cliente
        Cliente::create($request->all());

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        // Retornar la vista para editar un cliente
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'nullable|email|unique:clientes,correo_electronico,' . $id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // Actualizar el cliente
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
