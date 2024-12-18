<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenFiltrado extends Model
{
    use HasFactory;

    protected $table = 'almacen_filtrado';

    protected $fillable = ['producto_id', 'categoria_id', 'cantidad'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
