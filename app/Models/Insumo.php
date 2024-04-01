<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad_disponible',
        'unidad_medida',
        'stock',
    ];

    public function revolturas()
    {
        return $this->belongsToMany(Revoltura::class, 'revoltura_insumo')
            ->withPivot('cantidad');
    }

    public function actualizarCantidadComprada($cantidad)
    {
        $this->cantidad_disponible += $cantidad;
        $this->save();
    }

    public function actualizarCantidadDevuelta($cantidad)
    {
        $this->cantidad_disponible -= $cantidad;
        $this->save();
    }

    public function notificarCantidadBaja()
    {
        if ($this->cantidad_disponible < $this->stock) {
            return "Te estas quedando sin {$this->nombre}.";
        }
        return null; // Retorna null si no se debe mostrar notificación.
    }

    public function actualizarCantidadUsada($cantidad)
    {
        $this->cantidad_disponible -= $cantidad;
        $this->save();
    }
}
