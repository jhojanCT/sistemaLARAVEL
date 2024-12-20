<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    use HasFactory;
    protected $table = 'materias_primas';

    protected $fillable = ['nombre'];

    // Relación con ControlEntradaMateriaPrima
    public function entradas()
    {
        return $this->hasMany(ControlEntradaMateriaPrima::class);
    }
}
