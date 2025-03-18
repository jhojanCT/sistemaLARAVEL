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
        'saldo_final',
    ];

    public $timestamps = true;

    protected $casts = [
        'fecha' => 'datetime:Y-m-d',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function ventasMateriaPrima()
    {
        return $this->hasMany(VentaMateriaPrima::class);
    }

    public function ventasProducto()
    {
        return $this->hasMany(VentaProducto::class);
    }
}
