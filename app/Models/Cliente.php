<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'nombre',
        'correo_electronico',
        'telefono',
        'direccion',
    ];

    /**
     * Relación con los filtros (si un cliente tiene filtros asociados).
     */
    public function filtros()
    {
        return $this->hasMany(Filtro::class);
    }

    /**
     * Relación con los productos (si un cliente puede tener productos asociados).
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
