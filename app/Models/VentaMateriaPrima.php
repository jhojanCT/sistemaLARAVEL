<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaMateriaPrima extends Model
{
    use HasFactory;

    protected $table = 'ventas_materia_prima';

    protected $fillable = [
        'materia_prima_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'cliente_id',
        'cuenta_id',
        'fecha_venta',
        'a_credito',
        'cuota_inicial',
        'saldo_deuda',
        'estado',
    ];

    /**
     * Relación con la tabla materia_prima.
     */
    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class, 'materia_prima_id');
    }

    /**
     * Relación con la tabla cuentas.
     */
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    /**
     * Relación con la tabla clientes.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Lógica para actualizar el stock después de realizar una venta.
     */
    public static function actualizarStock($materiaPrimaId, $cantidadVendida, $aCredito = false)
    {
        // Buscar el registro en la tabla 'almacen_filtrado' y actualizar la cantidad
        $almacenFiltrado = AlmacenFiltrado::where('materia_prima_filtrada', $materiaPrimaId)->first();
        if ($almacenFiltrado) {
            if (!$aCredito) {
                // Solo actualiza el stock si no es una venta a crédito
                $almacenFiltrado->cantidad_materia_prima_filtrada -= $cantidadVendida;
                $almacenFiltrado->save();
            }
        }
    }

    /**
     * Realizar un pago sobre la deuda pendiente de la venta a crédito.
     */
    public function realizarPago($monto)
    {
        if ($this->a_credito) {
            $this->saldo_deuda -= $monto;

            // Si el saldo de deuda llega a 0 o menos, marca la deuda como saldada
            if ($this->saldo_deuda <= 0) {
                $this->saldo_deuda = 0;
                // Aquí puedes marcar la venta como "pagada" si lo deseas, por ejemplo:
                // $this->estado = 'pagada';
            }
            $this->save();

            // Actualizar el saldo de la cuenta correspondiente
            $this->cuenta->increment('saldo', $monto);
            
            // Registrar el pago en la tabla de pagos (si tienes una)
            $this->pagos()->create([
                'monto' => $monto,
                'fecha_pago' => now(),
            ]);
        }
    }

    /**
     * Calcular el saldo pendiente de la deuda.
     */
    public function calcularSaldoDeuda()
    {
        return $this->saldo_deuda;
    }

    /**
     * Verificar si la venta está completamente saldada.
     */
    public function estaSaldada()
    {
        return $this->saldo_deuda <= 0;
    }

    /**
     * Relación con los pagos realizados sobre esta venta.
     */
    public function pagos()
    {
        return $this->morphMany(Pago::class, 'venta');
    }
}
