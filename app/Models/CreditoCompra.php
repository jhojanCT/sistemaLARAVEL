<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',  // ID del proveedor
        'monto_total',
        'monto_pagado',
        'fecha',
        'control_entrada_id',
        'estado',  // Agregado para marcar si la compra está finalizada
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function controlEntradaMateriaPrima()
    {
        return $this->belongsTo(ControlEntradaMateriaPrima::class, 'control_entrada_id');
    }
    public function pagos()
    {
        return $this->hasMany(PagoCreditoCompra::class);
    }
}
