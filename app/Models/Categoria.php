<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación con los productos.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    /**
     * Relación con los filtros.
     */
    public function filtros()
    {
        return $this->hasMany(Filtro::class);
    }
}
