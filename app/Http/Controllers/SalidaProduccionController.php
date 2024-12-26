<?php

namespace App\Http\Controllers;

use App\Models\EntradaProduccion;
use App\Models\SalidaProduccion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalidaProduccionController extends Controller
{
    // Muestra todas las salidas de producción
    public function index()
    {
        $salidas = SalidaProduccion::with('entradaProduccion.producto')->get();
        return view('salidas_produccion.index', compact('salidas'));
    }

    // Crea una nueva salida de producción
    public function create()
    {
        // Recuperamos las entradas de producción finalizadas que no hayan sido utilizadas aún
        $entradas = EntradaProduccion::where('estado_produccion', 'finalizado')
                                      ->whereDoesntHave('salidasProduccion') // Filtramos las entradas que no tienen salidas asociadas
                                      ->get();
    
        return view('salidas_produccion.create', compact('entradas'));
    }
    
    

    // Almacena una nueva salida de producción
    public function store(Request $request)
    {
        Log::info('Formulario recibido', $request->all());
        
        // Validación de los datos
        $validated = $request->validate([
            'entrada_produccion_id' => 'required|exists:entradas_produccion,id',
            'cantidad_productos_hechos' => 'required|numeric',
            'precio_produccion' => 'required|numeric',
            'fecha_salida' => 'required|date',
        ]);
        
        // Obtener la entrada de producción seleccionada
        $entrada = EntradaProduccion::findOrFail($validated['entrada_produccion_id']);
        
        // Verificamos si el campo 'cantidad_materia_prima_en_uso' está vacío y lo tomamos de la tabla de EntradaProduccion
        $cantidadMateriaPrimaEnUso = $entrada->cantidad_materia_prima_en_uso;
        
        // Si la cantidad en uso no es válida o está vacía, asignamos un valor predeterminado (por ejemplo, 0)
        if (is_null($cantidadMateriaPrimaEnUso)) {
            $cantidadMateriaPrimaEnUso = 0;
        }
        
        // Crear la salida de producción (sin actualizar el stock aún)
        $salida = SalidaProduccion::create([
            'entrada_produccion_id' => $validated['entrada_produccion_id'],
            'cantidad_materia_prima_en_uso' => $cantidadMateriaPrimaEnUso,
            'cantidad_productos_hechos' => $validated['cantidad_productos_hechos'],
            'precio_produccion' => $validated['precio_produccion'],
            'fecha_salida' => $validated['fecha_salida'],
        ]);
        
        return redirect()->route('salidas_produccion.index')->with('success', 'Salida registrada con éxito.');
    }

    // Finaliza una entrada de producción
    public function finalizar(EntradaProduccion $entrada)
    {
        // Si la entrada ya está finalizada, no hacer nada
        if ($entrada->estado_produccion === 'finalizado') {
            return redirect()->route('salidas_produccion.create')->with('info', 'La entrada ya está finalizada.');
        }

        // Marca la entrada como finalizada
        $entrada->estado_produccion = 'finalizado';
        $entrada->save();

        return redirect()->route('salidas_produccion.create')->with('success', 'Entrada de producción finalizada.');
    }

    // Aprueba una salida de producción
    public function aprobar(SalidaProduccion $salida)
    {
        // Aprobamos la salida y actualizamos el stock del producto
        $producto = $salida->entradaProduccion->producto;
        $producto->cantidad += $salida->cantidad_productos_hechos;  // Actualizar cantidad de producto
        $producto->save();
    
        // Actualizamos el estado de la salida de producción
        $salida->esperado_aprobacion = 'aprobado';
        $salida->save();
    
        return redirect()->route('salidas_produccion.index')->with('success', 'Salida de producción aprobada.');
    }
    
    // Elimina una salida de producción
    public function eliminar(SalidaProduccion $salida)
    {
        $salida->delete();
        return redirect()->route('salidas_produccion.index')->with('success', 'Salida de producción eliminada.');
    }

    // Función para obtener la cantidad de materia prima en uso de una entrada de producción seleccionada
    public function obtenerMateriaPrimaEnUso(Request $request)
    {
        $entrada = EntradaProduccion::findOrFail($request->entrada_produccion_id);
        return response()->json([
            'cantidad_materia_prima_en_uso' => $entrada->cantidad_materia_prima_en_uso, // Asumimos que este campo existe en la tabla
        ]);
    }
}
