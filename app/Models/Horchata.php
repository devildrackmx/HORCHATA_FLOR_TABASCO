<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horchata extends Model
{
    use HasFactory;

    protected $fillable = [
        'presentacion',
    ];

    /* public function actualizarCantidadUsada($cantidad)
    {
        $this->cantidad -= $cantidad;
        $this->save();
    } */

    /* public function embasados()
    {
        return $this->belongsToMany(Embasado::class)
            ->withPivot('num_cajas');
    } */

    public function embasados()
    {
        return $this->belongsToMany(Horchata::class, 'embasado_horchata')
            ->withPivot('num_cajas');
    }
}
