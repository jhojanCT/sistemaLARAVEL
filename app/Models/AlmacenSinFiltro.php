<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenSinFiltro extends Model
{
    use HasFactory;

    protected $table = 'almacen_sin_filtro';

    protected $fillable = [
        'proveedor_id',
        'materia_prima',
        'cantidad_total',
    ];

    /**
     * Relación con Proveedores
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Actualiza o crea el registro consolidado en AlmacenSinFiltro
     */
    public static function actualizarAlmacen($entrada)
    {
        // Busca si ya existe un registro para el mismo proveedor y materia prima
        $registro = self::where('proveedor_id', $entrada->proveedor_id)
            ->where('materia_prima', $entrada->materia_prima)
            ->first();

        if ($registro) {
            // Si existe, suma la cantidad a la cantidad total
            $registro->cantidad_total += $entrada->cantidad;
            $registro->save();
        } else {
            // Si no existe, crea un nuevo registro
            self::create([
                'proveedor_id' => $entrada->proveedor_id,
                'materia_prima' => $entrada->materia_prima,
                'cantidad_total' => $entrada->cantidad,
            ]);
        }
    }
}
