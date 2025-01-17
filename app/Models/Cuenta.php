<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'saldo'];

    public function ventasMateriaPrima()
    {
        return $this->hasMany(VentaMateriaPrima::class);
    }

    // Relación con las ventas de producto
    public function ventasProducto()
    {
        return $this->hasMany(VentaProducto::class);
    }
}
