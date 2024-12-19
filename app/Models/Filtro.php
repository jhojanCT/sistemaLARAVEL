<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    use HasFactory;

    protected $table = 'filtros';

    protected $fillable = [
        'proveedor_id',
        'almacen_sin_filtro_id',
        'cantidad_usada',
        'desperdicio',
        'existencia_filtrada',
        'supervisor',
        'fecha_filtro',
    ];

    /**
     * Relación con la tabla Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con la tabla AlmacenSinFiltro
     */
    public function almacenSinFiltro()
    {
        return $this->belongsTo(AlmacenSinFiltro::class);
    }

    /**
     * Relación con la tabla AlmacenFiltrado
     */
    public function almacenFiltrado()
    {
        return $this->hasOne(AlmacenFiltrado::class);
    }

    /**
     * Evento para actualizar el AlmacenFiltrado
     */
    protected static function booted()
    {
        static::created(function ($filtro) {
            AlmacenFiltrado::actualizarAlmacen($filtro);
        });
    }
}
