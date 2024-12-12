<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención de nombres en plural
    protected $table = 'productos';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'categoria_id',
        'nombre',
        'cantidad',
        'detalles',
    ];

    // Relación con la tabla 'Categoria'
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con la tabla 'Filtro'
    public function filtros()
    {
        return $this->hasMany(Filtro::class);
    }
}
