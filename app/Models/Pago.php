<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // Atributos asignables
    protected $fillable = [
        'monto', 'venta_id', 'venta_type', 'cuota_numero'
    ];

    // Cast para asegurar que el monto sea un número decimal
    protected $casts = [
        'monto' => 'decimal:2',
    ];

    // Relación polimórfica con ventas (materia prima o producto)
    public function venta()
    {
        return $this->morphTo();
    }

    // Método para evitar pagos duplicados con el mismo monto, venta y cuota
    public static function registrarPagoUnico($venta, $monto, $cuota_numero)
    {
        $pagoExistente = self::where('venta_id', $venta->id)
            ->where('venta_type', get_class($venta))
            ->where('monto', $monto)
            ->where('cuota_numero', $cuota_numero) // Verificar que la cuota no esté registrada
            ->first();

        if (!$pagoExistente) {
            return self::create([
                'monto' => $monto,
                'venta_id' => $venta->id,
                'venta_type' => get_class($venta),
                'cuota_numero' => $cuota_numero,
            ]);
        }

        return null;
    }
}
