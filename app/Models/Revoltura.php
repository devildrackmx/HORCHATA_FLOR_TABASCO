<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revoltura extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_realizacion',
        'turno',
        'num_revoltura',

    ];

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'revoltura_insumo')
            ->withPivot('cantidad');
    }
}
