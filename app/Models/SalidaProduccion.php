<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaProduccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrada_produccion_id',
        'cantidad',
        'fecha_hora_salida',
    ];

    public function entradaProduccion()
    {
        return $this->belongsTo(EntradaProduccion::class);
    }
}
