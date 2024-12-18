<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id',
        'producto_id',
        'categoria_id',
        'cantidad_usada',
        'desperdicio',
        'existencia_filtrada',
        'supervisor',
        'fecha_filtro'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
