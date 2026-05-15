<?php

/**
 * EstimadorPesoService
 *
 * Participante GoF: Context
 *
 * Recibe IAlgoritmoEstimacion por constructor injection.
 * El método estimar() NO tiene if / else / switch.
 * Permite cambiar la estrategia en tiempo de ejecución (fallback).
 *
 * En Laravel el ServiceProvider decide qué implementación inyectar:
 *   $this->app->bind(IAlgoritmoEstimacion::class, AlgoritmoYolov8::class);
 */
class EstimadorPesoService
{
    public function __construct(
        private IAlgoritmoEstimacion $algoritmo
    ) {}

    public function setAlgoritmo(IAlgoritmoEstimacion $algoritmo): void
    {
        $this->algoritmo = $algoritmo;
        echo "[EstimadorPesoService] Estrategia → " . get_class($this->algoritmo) . "\n";
    }

    /**
     * Delega completamente al algoritmo inyectado.
     * Sin if-else. Sin switch.
     */
    public function estimar(array $datosEntrada): ResultadoEstimacion
    {
        echo "[EstimadorPesoService] Usando: " . get_class($this->algoritmo) . "\n";
        return $this->algoritmo->ejecutar($datosEntrada);
    }
}