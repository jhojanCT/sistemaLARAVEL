<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'nombre',
        'correo_electronico',
        'telefono',
        'direccion',
    ];

    /**
     * Relación con los productos (si un proveedor tiene muchos productos).
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
