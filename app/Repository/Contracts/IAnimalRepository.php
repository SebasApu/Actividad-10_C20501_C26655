<?php

namespace App\Repository\Contracts;

use App\Repository\Models\Animal;

interface IAnimalRepository
{
    public function findByArete(string $arete): ?Animal;

    public function findAllByRancho(int $ranchoId): array;

    public function save(Animal $animal): void;

    public function delete(int $id): void;
}
