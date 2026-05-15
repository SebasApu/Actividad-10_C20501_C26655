<?php

namespace App\Factory\Models;

class Brahman extends Raza
{
    public function getNombre(): string
    {
        return 'Brahman';
    }

    public function getPesoPromedioKg(): float
    {
        return 480.0;
    }

    public function getRangoPesoKg(): array
    {
        return [
            'min' => 350.0,
            'max' => 900.0,
        ];
    }

    public function esAptaMejoramientoGenetico(): bool
    {
        return true;
    }
}
