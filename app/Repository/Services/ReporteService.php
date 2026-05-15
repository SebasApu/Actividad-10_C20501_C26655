<?php

namespace App\Repository\Services;

use App\Repository\Contracts\IAnimalRepository;
use App\Repository\Models\Animal;

class ReporteService
{
    public function __construct(
        private IAnimalRepository $animalRepository
    ) {}

    public function generarReportePorRancho(int $ranchoId): array
    {
        $animales = $this->animalRepository->findAllByRancho($ranchoId);

        return array_map(function (Animal $animal) {
            return [
                'arete'         => $animal->arete,
                'raza'          => $animal->raza,
                'peso_actual'   => $animal->getUltimoPesoKg(),
                'tiene_alertas' => $this->tieneAlertaDePeso($animal),
            ];
        }, $animales);
    }

    public function obtenerFichaAnimal(string $arete): ?Animal
    {
        return $this->animalRepository->findByArete($arete);
    }

    public function calcularPromedioPesoRancho(int $ranchoId): float
    {
        $animales = $this->animalRepository->findAllByRancho($ranchoId);

        if (empty($animales)) {
            return 0.0;
        }

        $pesos = array_filter(
            array_map(fn(Animal $a) => $a->getUltimoPesoKg(), $animales)
        );

        if (empty($pesos)) {
            return 0.0;
        }

        return array_sum($pesos) / count($pesos);
    }

    private function tieneAlertaDePeso(Animal $animal): bool
    {
        $pesoActual = $animal->getUltimoPesoKg();

        if ($pesoActual === null) {
            return false;
        }

        return $pesoActual < ($animal->peso_kg * 0.6);
    }
}
