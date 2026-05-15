<?php

namespace App\Repository\Repositories;

use App\Repository\Contracts\IAnimalRepository;
use App\Repository\Models\Animal;

class EloquentAnimalRepository implements IAnimalRepository
{
    public function findByArete(string $arete): ?Animal
    {
        return Animal::where('arete', $arete)->first();
    }

    public function findAllByRancho(int $ranchoId): array
    {
        return Animal::where('rancho_id', $ranchoId)
            ->orderBy('arete')
            ->get()
            ->all();
    }

    public function save(Animal $animal): void
    {
        $animal->save();
    }

    public function delete(int $id): void
    {
        Animal::destroy($id);
    }
}
