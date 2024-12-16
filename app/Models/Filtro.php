<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    protected $fillable = [
        'categoria',
        'producto_id', // Ajustar para utilizar producto_id como clave foránea
        'proveedor',
        'existencia_total_inicial',
        'desperdicio',
        'existencia_total_filtrada',
        'filtrado_supervisor',
        'fecha_filtro',
    ];
     // Laravel 10+ (Reemplazar `$dates`)
     protected $casts = [
        'fecha_filtro' => 'datetime',
    ];

    // Evento que se dispara antes de guardar
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($filtro) {
            $filtro->existencia_total_filtrada = $filtro->existencia_total_inicial - $filtro->desperdicio;
        });
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}

