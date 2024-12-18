<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenSinFiltro extends Model
{
    use HasFactory;

    protected $table = 'almacen_sin_filtro';

    protected $fillable = ['proveedor_id', 'producto_id', 'categoria_id', 'cantidad', 'encargado', 'fecha_llegada'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
