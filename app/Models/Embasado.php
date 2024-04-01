<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embasado extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'turno',
    ];

    public function horchatas()
    {
        return $this->belongsToMany(Horchata::class, 'embasado_horchata')
            ->withPivot('num_cajas');
    }
}
