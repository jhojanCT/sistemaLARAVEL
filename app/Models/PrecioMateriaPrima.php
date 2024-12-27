<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioMateriaPrima extends Model
{
    use HasFactory;

    protected $table = 'precios_materia_prima';

    protected $fillable = [
        'materia_prima_id',
        'precio_unitario',
        'fecha_actualizacion'
    ];

    /**
     * Relación con la tabla materia_prima.
     */
    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materia_prima_id');
    }
}
