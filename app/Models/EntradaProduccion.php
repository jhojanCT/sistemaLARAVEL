<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaProduccion extends Model
{
    use HasFactory;

    protected $table = 'entradas_produccion';

    protected $fillable = [
        'producto_id',
        'almacen_filtrado_id',
        'materia_prima_en_uso',
        'estado_produccion',
        'fecha_entrada',
    ];

    /**
     * Relación con Producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con AlmacenFiltrado.
     */
    public function almacenFiltrado()
    {
        return $this->belongsTo(AlmacenFiltrado::class);
    }
    public function salidasProduccion()
    {
        return $this->hasMany(SalidaProduccion::class);
    }
}
    