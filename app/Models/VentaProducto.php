<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    use HasFactory;

    protected $table = 'ventas_productos';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'cliente_id',
        'fecha_venta',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
