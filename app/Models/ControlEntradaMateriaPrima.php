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
        'almacen_sin_filtro_id',
        'precio_unitario_por_kilo',
        'precio_total',
        'compra_credito',  // Indicador de si la compra es a crédito
    ];

    // Relación con el proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con la materia prima
    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materia_prima_id');
    }

    // Relación con el almacén sin filtro
    public function almacenSinFiltro()
    {
        return $this->belongsTo(AlmacenSinFiltro::class, 'almacen_sin_filtro_id');
    }

    // Relación con CréditoCompra (uno a uno)
    public function creditoCompra()
    {
        return $this->hasOne(CreditoCompra::class, 'control_entrada_id');
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

            // Calcular el precio total para la entrada actual
            if ($entry->precio_unitario_por_kilo && $entry->cantidad) {
                $entry->precio_total = $entry->precio_unitario_por_kilo * $entry->cantidad;
                $entry->save();
            }

            // Si la compra es a crédito, creamos el registro en CreditoCompra
            if ($entry->compra_credito == 1) {
                \App\Models\CreditoCompra::create([
                    'control_entrada_id' => $entry->id,
                    'proveedor_id' => $entry->proveedor_id,  // Asociar con el proveedor de la entrada
                    'monto_total' => $entry->precio_total,  // Usando el precio total calculado
                    'monto_pagado' => 0,  // El monto pagado es 0 al principio
                    'fecha' => now(),  // La fecha de la compra
                ]);
            }
        });
    }
}
