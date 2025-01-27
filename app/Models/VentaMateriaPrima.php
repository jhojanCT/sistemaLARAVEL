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
        'encargado', // Campo encargado incluido en fillable
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
        $almacenFiltrado = AlmacenFiltrado::where('materia_prima_filtrada', $materiaPrimaId)->first();
        if ($almacenFiltrado) {
            if (!$aCredito) {
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

            if ($this->saldo_deuda <= 0) {
                $this->saldo_deuda = 0;
            }
            $this->save();

            $this->cuenta->increment('saldo', $monto);
            
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

    /**
     * Realizar un pago inicial al registrar una venta a crédito.
     */
    public function realizarPagoInicial($monto)
    {
        if ($monto > $this->saldo_deuda) {
            throw new \Exception('El monto inicial excede el saldo de deuda.');
        }

        $this->decrement('saldo_deuda', $monto);

        $cuenta = Cuenta::findOrFail($this->cuenta_id);
        $cuenta->increment('saldo', $monto);
    }
}
