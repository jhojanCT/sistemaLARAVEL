<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = [
        'nombre',
        'correo_electronico',
        'password',
        'rol_id',
    ];

    // Campos que deben ser ocultos en las respuestas (por seguridad)
    protected $hidden = [
        'password',
    ];

    // Campos que deben ser casteados a tipos específicos
    protected $casts = [
        'correo_electronico' => 'string',
        'password' => 'hashed',
    ];

    /**
     * Relación con el rol.
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}
