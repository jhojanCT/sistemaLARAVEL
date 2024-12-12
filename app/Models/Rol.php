<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación con los usuarios.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
