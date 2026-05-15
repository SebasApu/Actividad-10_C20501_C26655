<?php

class ResultadoEstimacion
{
    public function __construct(
        public readonly float $pesoKg,
        public readonly float $confianzaPorcentaje,
        public readonly string $metodoUsado
    ) {}

    public function __toString(): string
    {
        return sprintf(
            "Peso: %.2f kg | Confianza: %.1f%% | Método: %s",
            $this->pesoKg,
            $this->confianzaPorcentaje,
            $this->metodoUsado
        );
    }
}