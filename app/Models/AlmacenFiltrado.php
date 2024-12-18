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
     * Actualiza o crea el registro consolidado en AlmacenFiltrado
     */
    public static function actualizarAlmacen($filtro)
    {
        // Busca si ya existe un registro para el mismo proveedor y materia prima
        $registro = self::where('proveedor_id', $filtro->proveedor_id)
            ->where('materia_prima_filtrada', $filtro->almacenSinFiltro->materia_prima)
            ->first();

        if ($registro) {
            // Si existe, actualiza la cantidad de materia prima filtrada
            $registro->cantidad_materia_prima_filtrada += $filtro->existencia_filtrada;
            $registro->save();
        } else {
            // Si no existe, crea un nuevo registro
            self::create([
                'proveedor_id' => $filtro->proveedor_id,
                'materia_prima_filtrada' => $filtro->almacenSinFiltro->materia_prima,
                'cantidad_materia_prima_filtrada' => $filtro->existencia_filtrada,
            ]);
        }
    }
}
