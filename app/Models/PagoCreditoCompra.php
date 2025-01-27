<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCreditoCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'credito_compra_id',  // ID del crédito de compra
        'monto_pagado',  // Monto de cada cuota pagada
        'fecha_pago',  // Fecha en que se hizo el pago
    ];

    public function creditoCompra()
    {
        return $this->belongsTo(CreditoCompra::class);
    }
}
