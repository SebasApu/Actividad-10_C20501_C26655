<?php

/**
 * AlgoritmoRegresionLineal
 *
 * Participante GoF: ConcreteStrategy
 *
 * Estima el peso con una fórmula de regresión lineal
 * basada en la circunferencia torácica del animal.
 *
 * Fórmula (Schaeffer adaptada, simplificada):
 *   peso = 87.5 * circunferencia_m - 60
 *
 * Requiere en $datosEntrada:
 *   'circunferencia_toracica_m' => float
 */
class AlgoritmoRegresionLineal implements IAlgoritmoEstimacion
{
    private const COEF_TORACICA = 87.5;
    private const INTERCEPTO    = -60.0;

    public function ejecutar(array $datosEntrada): ResultadoEstimacion
    {
        if (! isset($datosEntrada['circunferencia_toracica_m'])) {
            throw new InvalidArgumentException(
                "Se requiere 'circunferencia_toracica_m'."
            );
        }

        $toracica = $datosEntrada['circunferencia_toracica_m'];
        echo "[RegresionLineal] Circunferencia torácica = {$toracica} m\n";

        $peso = self::COEF_TORACICA * $toracica + self::INTERCEPTO;

        return new ResultadoEstimacion(
            pesoKg:              round(max($peso, 0), 2),
            confianzaPorcentaje: 78.0,
            metodoUsado:         'Regresión Lineal'
        );
    }
}