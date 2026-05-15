<?php

namespace App\Factory\Factories;

use App\Factory\Contracts\IRazaFactory;
use App\Factory\Models\Brahman;
use App\Factory\Models\Nelore;
use App\Factory\Models\Raza;
use InvalidArgumentException;

class RazaFactory implements IRazaFactory
{
    private array $razas = [
        'brahman' => Brahman::class,
        'nelore'  => Nelore::class,
        // Para agregar Angus: 'angus' => Angus::class,
    ];

    public function create(string $nombreRaza): Raza
    {
        $clave = strtolower(trim($nombreRaza));

        if (!array_key_exists($clave, $this->razas)) {
            throw new InvalidArgumentException(
                "Raza '{$nombreRaza}' no registrada. Disponibles: " .
                implode(', ', array_keys($this->razas))
            );
        }

        $clase = $this->razas[$clave];

        return new $clase();
    }

    public function getRazasDisponibles(): array
    {
        return array_keys($this->razas);
    }
}
