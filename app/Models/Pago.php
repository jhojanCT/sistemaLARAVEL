<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // Atributos asignables
    protected $fillable = [
        'monto', 'venta_id', 'venta_type'
    ];

    // Cast para asegurar que el monto sea un número decimal
    protected $casts = [
        'monto' => 'decimal:2',
    ];

    // Relación polimórfica con ventas
    public function venta()
    {
        return $this->morphTo();
    }

    // Método para evitar pagos duplicados con el mismo monto y venta
    public static function registrarPagoUnico($venta, $monto)
    {
        $pagoExistente = self::where('venta_id', $venta->id)
            ->where('venta_type', get_class($venta))
            ->where('monto', $monto)
            ->first();

        if (!$pagoExistente) {
            return self::create([
                'monto' => $monto,
                'venta_id' => $venta->id,
                'venta_type' => get_class($venta),
            ]);
        }

        return null;
    }
}
