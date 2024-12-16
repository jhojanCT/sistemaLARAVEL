<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
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

    // Casts para definir el tipo de datos
    protected $casts = [
        'cantidad' => 'integer',
        'precio_venta' => 'float',
        'fecha_entrada' => 'date',
        'existencia_total' => 'float',
        'existencia_actual' => 'float',
        'existencia_actual_en_uso' => 'float',
        'porcentaje_elaboracion' => 'float',
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

    /**
     * Método para obtener el filtro más reciente relacionado con el producto.
     * Nota: Esto no es una relación directa.
     */
    public function getFiltro()
    {
        return Filtro::where('producto_id', $this->producto_id)
            ->latest('fecha_filtro')
            ->first();
    }

    /**
     * Obtener la existencia filtrada del producto asociado.
     * Este método consulta el modelo `Filtro`.
     */
    public static function getExistenciaFiltrada($producto_id)
    {
        $filtro = Filtro::where('producto_id', $producto_id)
            ->latest('fecha_filtro')
            ->first();

        return $filtro ? $filtro->existencia_total_filtrada : 0;
    }

    /**
     * Mutator para asegurar que el porcentaje de elaboración no exceda 100.
     */
    public function setPorcentajeElaboracionAttribute($value)
    {
        $this->attributes['porcentaje_elaboracion'] = min(max($value, 0), 100);
    }

    /**
     * Accessor para obtener una descripción del supervisor si está vacío.
     */
    public function getSupervisorAttribute($value)
    {
        return $value ?: 'Desconocido';
    }
}
