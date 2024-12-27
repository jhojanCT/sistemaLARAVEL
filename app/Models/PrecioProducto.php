<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioProducto extends Model
{
    use HasFactory;

    protected $table = 'precios_productos';

    protected $fillable = [
        'producto_id',
        'precio_unitario',
        'fecha_actualizacion',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
