<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlEntradaMateriaPrima extends Model
{
    use HasFactory;

    protected $table = 'control_entrada_materia_prima';
    protected $fillable = [
        'proveedor_id',
        'materia_prima_id',
        'cantidad',
        'encargado',
        'fecha_llegada',
        'almacen_sin_filtro_id'
    ];

    // Relación con el proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function materiaPrima()
    {
    return $this->belongsTo(MateriaPrima::class, 'materia_prima_id');
    }


    // Relación con el almacén sin filtro
    public function almacenSinFiltro()
    {
        return $this->belongsTo(AlmacenSinFiltro::class, 'almacen_sin_filtro_id');
    }

    /**
     * Evento para actualizar la tabla almacen_sin_filtro
     */
    protected static function booted()
    {
        static::created(function ($entry) {
            // Sumar todas las cantidades para la misma materia prima del proveedor actual
            $totalCantidad = self::where('materia_prima_id', $entry->materia_prima_id)
                                 ->where('proveedor_id', $entry->proveedor_id)
                                 ->sum('cantidad');
    
            // Crear o actualizar la entrada en la tabla almacen_sin_filtro
            \App\Models\AlmacenSinFiltro::updateOrCreate(
                [
                    'proveedor_id' => $entry->proveedor_id,
                    'materia_prima_id' => $entry->materia_prima_id,
                ],
                [
                    'cantidad_total' => $totalCantidad,
                ]
            );
        });
    }
    
}
