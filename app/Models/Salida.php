<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    protected $table = 'salidas';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'producto_id',
        'cantidad',
        'descripcion',
        'fecha_salida',
        'supervisor',
    ];

    /**
     * Relación con el producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
