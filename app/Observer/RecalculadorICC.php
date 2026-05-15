<?php

/**
 * RecalculadorICC
 *
 * Participante GoF: ConcreteObserver
 *
 * Recalcula el Índice de Condición Corporal (ICC)
 * del animal cuando se registra un nuevo peso.
 */
class RecalculadorICC implements IRegistroPesoObserver
{
    public function onPesoRegistrado(RegistroPeso $registro): void
    {
        // Fórmula simplificada (ilustrativa): ICC = pesoKg / 100
        // En producción usaría tablas de referencia por raza y edad.
        $icc = round($registro->pesoKg / 100, 2);

        // En producción: Animal::find($registro->animal->id)->update(['icc' => $icc])
        echo "[RecalculadorICC] 📊 ICC de {$registro->animal->arete}: {$icc}\n";
    }
}