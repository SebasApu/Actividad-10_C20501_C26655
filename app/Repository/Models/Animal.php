<?php

namespace App\Repository\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'animales';

    protected $fillable = [
        'arete',
        'rancho_id',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'peso_kg',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'peso_kg'          => 'float',
    ];

    public function getUltimoPesoKg(): ?float
    {
        return $this->peso_kg;
    }
}
