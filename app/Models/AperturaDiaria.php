<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaDiaria extends Model
{
    use HasFactory;
    
    protected $table = 'aperturas_diarias';

    protected $fillable = ['fecha', 'saldo_inicial'];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public $timestamps = true;
}
