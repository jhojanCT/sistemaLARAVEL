<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'producto_id',
        'proveedor_id',
        'cantidad',
        'precio_venta',
        'fecha_entrada',
        'existencia_total',
        'existencia_actual',
        'existencia_actual_en_uso',
        'porcentaje_elaboracion',
        'supervisor',
    ];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con el modelo Filtro
    public function filtro()
    {
        return $this->belongsTo(Filtro::class, 'producto_id', 'producto_id');
    }

    // Función para obtener la existencia filtrada de la tabla Filtros
    public static function getExistenciaFiltrada($producto_id)
    {
        $filtro = Filtro::where('producto_id', $producto_id)
            ->latest('fecha_filtro')
            ->first();

        return $filtro ? $filtro->existencia_total_filtrada : 0;
    }
}
