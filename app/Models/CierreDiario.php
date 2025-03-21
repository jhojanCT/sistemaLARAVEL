<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreDiario extends Model
{
    use HasFactory;

    protected $table = 'cierres_diarios';

    protected $fillable = [
        'fecha',
        'total_ventas_materia_prima',
        'total_ventas_producto',
        'total_pagos',
        'total_compras_materia_prima', // Agregado para registrar las compras
        'saldo_final',
    ];

    public $timestamps = true;

    protected $casts = [
        'fecha' => 'datetime:Y-m-d',
    ];

    // Relación con los pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // Relación con las ventas de materia prima
    public function ventasMateriaPrima()
    {
        return $this->hasMany(VentaMateriaPrima::class);
    }

    // Relación con las ventas de productos
    public function ventasProducto()
    {
        return $this->hasMany(VentaProducto::class);
    }

    // Relación con las compras de materia prima
    public function comprasMateriaPrima()
    {
        return $this->hasMany(ControlEntradaMateriaPrima::class, 'fecha_llegada', 'fecha');
    }
}
