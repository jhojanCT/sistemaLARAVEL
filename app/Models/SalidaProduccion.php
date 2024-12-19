<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaProduccion extends Model
{
    use HasFactory;

    protected $table = 'salidas_produccion';

    protected $fillable = [
        'entrada_produccion_id',
        'cantidad_productos_hechos',
        'cantidad_materia_prima_en_uso',
        'precio_produccion',
        'esperado_aprobacion',
        'fecha_salida',
    ];

    /**
     * Relación con EntradaProduccion.
     */
    public function entradaProduccion()
    {
        return $this->belongsTo(EntradaProduccion::class);
    }

    /**
     * Relación con Producto.
     */
    public function producto()
    {
        return $this->hasOneThrough(Producto::class, EntradaProduccion::class);
    }
}
    
