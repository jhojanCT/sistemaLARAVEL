<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaMateriaPrima extends Model
{
    use HasFactory;

    protected $table = 'ventas_materia_prima';

    protected $fillable = [
        'materia_prima_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'cliente_id',
        'fecha_venta'
    ];

    /**
     * Relación con la tabla materia_prima.
     */
    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materia_prima_id');
    }

    /**
     * Relación con la tabla clientes.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Lógica para actualizar el stock después de realizar una venta.
     */
    public static function actualizarStock($materiaPrimaId, $cantidadVendida)
    {
        // Buscar el registro en la tabla 'almacen_filtrado' y actualizar la cantidad
        $almacenFiltrado = AlmacenFiltrado::where('materia_prima_filtrada', $materiaPrimaId)->first();
        if ($almacenFiltrado) {
            // Restar la cantidad vendida del stock
            $almacenFiltrado->cantidad_materia_prima_filtrada -= $cantidadVendida;
            $almacenFiltrado->save();
        }
    }
}
