<?php

namespace App\Repository\Repositories;

use App\Repository\Contracts\IAnimalRepository;
use App\Repository\Models\Animal;
use RuntimeException;

class InMemoryAnimalRepository implements IAnimalRepository
{
    /** @var Animal[] Almacén indexado por arete, sin base de datos */
    private array $store = [];

    public function findByArete(string $arete): ?Animal
    {
        return $this->store[$arete] ?? null;
    }

    public function findAllByRancho(int $ranchoId): array
    {
        return array_values(
            array_filter(
                $this->store,
                fn(Animal $animal) => $animal->rancho_id === $ranchoId
            )
        );
    }

    public function save(Animal $animal): void
    {
        if (empty($animal->arete)) {
            throw new RuntimeException('El animal debe tener un arete para ser guardado.');
        }

        $this->store[$animal->arete] = $animal;
    }

    public function delete(int $id): void
    {
        foreach ($this->store as $arete => $animal) {
            if ($animal->id === $id) {
                unset($this->store[$arete]);
                return;
            }
        }
    }

    public function limpiar(): void
    {
        $this->store = [];
    }

    public function contar(): int
    {
        return count($this->store);
    }
}
