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
        'cuenta_id',
        'fecha_venta',
        'a_credito',
        'cuota_inicial',
        'saldo_deuda',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con Cuenta
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Pagos (polimórfica)
    public function pagos()
    {
        return $this->morphMany(Pago::class, 'venta');
    }
}
