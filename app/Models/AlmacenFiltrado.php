<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenFiltrado extends Model
{
    use HasFactory;

    protected $table = 'almacen_filtrado';

    protected $fillable = [
        'proveedor_id',
        'materia_prima_filtrada',
        'cantidad_materia_prima_filtrada',
    ];

    /**
     * Relación con la tabla Proveedores
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con los filtros
     */
    public function filtros()
    {
        return $this->hasMany(Filtro::class);
    }
    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materia_prima_filtrada');
    }

    /**
     * Actualiza o crea el registro consolidado en AlmacenFiltrado
     */
    public static function actualizarAlmacen($filtro)
    {
        // Usar un "firstOrCreate" para simplificar la lógica de creación o actualización
        $registro = self::updateOrCreate(
            [
                'proveedor_id' => $filtro->proveedor_id,
                'materia_prima_filtrada' => $filtro->almacenSinFiltro->materia_prima_id,
            ],
            [
                'cantidad_materia_prima_filtrada' => \DB::raw('cantidad_materia_prima_filtrada + ' . $filtro->existencia_filtrada)
            ]
        );
        
        // Si el registro ya existía, `updateOrCreate` actualizará la cantidad de materia filtrada correctamente.
        // No es necesario el chequeo adicional si utilizamos `updateOrCreate`.
    }
}
