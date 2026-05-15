<?php

namespace App\Factory\Models;

abstract class Raza
{
    abstract public function getNombre(): string;

    abstract public function getPesoPromedioKg(): float;

    abstract public function getRangoPesoKg(): array;

    abstract public function esAptaMejoramientoGenetico(): bool;

    public function describir(): string
    {
        return sprintf(
            'Raza: %s | Peso promedio: %.1f kg | Mejoramiento genético: %s',
            $this->getNombre(),
            $this->getPesoPromedioKg(),
            $this->esAptaMejoramientoGenetico() ? 'Sí' : 'No'
        );
    }
}
