<?php

namespace App\Factory\Models;

class Nelore extends Raza
{
    public function getNombre(): string
    {
        return 'Nelore';
    }

    public function getPesoPromedioKg(): float
    {
        return 460.0;
    }

    public function getRangoPesoKg(): array
    {
        return [
            'min' => 300.0,
            'max' => 700.0,
        ];
    }

    public function esAptaMejoramientoGenetico(): bool
    {
        return true;
    }
}
