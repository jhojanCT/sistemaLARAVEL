<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    protected $fillable = [
        'categoria',
        'producto',
        'proveedor',
        'existencia_total_inicial',
        'desperdicio',
        'existencia_total_filtrada',
        'filtrado_supervisor',
        'fecha_filtro',
    ];

    // Evento que se dispara antes de guardar
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($filtro) {
            $filtro->existencia_total_filtrada = $filtro->existencia_total_inicial - $filtro->desperdicio;
        });
    }
}
