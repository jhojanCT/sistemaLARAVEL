<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',
        'almacen_sin_filtro_id',
        'cantidad_usada',
        'desperdicio',
        'existencia_filtrada',
        'supervisor',
        'fecha_filtro',
        'almacen_filtrado_id',
    ];

    /**
     * Relación con el proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con AlmacenSinFiltro.
     */
    public function almacenSinFiltro()
    {
        return $this->belongsTo(AlmacenSinFiltro::class);
    }

    /**
     * Relación con AlmacenFiltrado.
     */
    public function almacenFiltrado()
    {
        return $this->belongsTo(AlmacenFiltrado::class);
    }

    
    
}
