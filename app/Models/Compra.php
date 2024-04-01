<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_compra',
        'numero_orden',
        'proveedor_id',
        'estado',
        'tipo_compra',
        'tipo_moneda',
        'subtotal',
        'iva',
        'total',
    ];


    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'compra_insumo')
            ->withPivot('cantidad', 'precio_unitario', 'importe')
            ->withTimestamps();
    }

    // Método para calcular el subtotal de la compra
    public function calcularSubtotal()
    {
        return $this->insumos->sum(function ($insumo) {
            return $insumo->pivot->importe;
        });
    }

    // Método para calcular el total de la compra, incluyendo el IVA si está presente
    public function calcularTotal()
    {
        $subtotal = $this->calcularSubtotal();
        $total = $subtotal + ($subtotal * ($this->iva / 100));
        return $total;
    }

    // Método para actualizar el subtotal y el IVA basado en los detalles de la compra
    /* public function actualizarTotales()
    {
        $this->subtotal = $this->calcularSubtotal();
        $this->save();

        // Asegurarse de manejar adecuadamente el caso en que el IVA sea nulo
        if ($this->iva !== null) {
            $this->iva = $this->calcularTotal() - $this->subtotal;
            $this->save();
        }
    } */

    public function actualizarTotales()
    {
        $this->subtotal = $this->calcularSubtotal();

        // Deshabilitar temporalmente eventos para evitar bucles infinitos
        $this->withoutEvents(function () {
            $this->save();
        });

        // Asegurarse de manejar adecuadamente el caso en que el IVA sea nulo
        if ($this->iva !== null) {
            $this->iva = $this->calcularTotal() - $this->subtotal;

            // Deshabilitar temporalmente eventos para evitar bucles infinitos
            $this->withoutEvents(function () {
                $this->save();
            });
        }
    }
}
