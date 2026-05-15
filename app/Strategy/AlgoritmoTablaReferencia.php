<?php

/**
 * AlgoritmoTablaReferencia
 *
 * Participante GoF: ConcreteStrategy
 *
 * Estima el peso por tabla de referencia según raza y edad.
 * Sin dependencias externas: ideal como fallback de YOLOv8.
 *
 * Requiere en $datosEntrada:
 *   'raza'       => string  ('Brahman' | 'Nelore' | 'Angus')
 *   'meses_edad' => int
 */
class AlgoritmoTablaReferencia implements IAlgoritmoEstimacion
{
    private const TABLA = [
        'Brahman' => [6 => 180, 12 => 280, 18 => 370, 24 => 450, 36 => 520],
        'Nelore'  => [6 => 160, 12 => 260, 18 => 350, 24 => 430, 36 => 500],
        'Angus'   => [6 => 200, 12 => 310, 18 => 400, 24 => 490, 36 => 560],
    ];

    public function ejecutar(array $datosEntrada): ResultadoEstimacion
    {
        $raza  = $datosEntrada['raza']       ?? 'Brahman';
        $meses = $datosEntrada['meses_edad'] ?? 18;

        echo "[TablaReferencia] Raza={$raza}, meses={$meses}\n";

        $tabla = self::TABLA[$raza] ?? self::TABLA['Brahman'];
        $peso  = $this->interpolar($tabla, $meses);

        return new ResultadoEstimacion(
            pesoKg:              round($peso, 2),
            confianzaPorcentaje: 65.0,
            metodoUsado:         'Tabla de Referencia'
        );
    }

    private function interpolar(array $tabla, int $meses): float
    {
        ksort($tabla);
        $claves = array_keys($tabla);

        if ($meses <= $claves[0])  return $tabla[$claves[0]];
        if ($meses >= end($claves)) return $tabla[end($claves)];

        for ($i = 0; $i < count($claves) - 1; $i++) {
            $k1 = $claves[$i];
            $k2 = $claves[$i + 1];
            if ($meses >= $k1 && $meses <= $k2) {
                $t = ($meses - $k1) / ($k2 - $k1);
                return $tabla[$k1] + $t * ($tabla[$k2] - $tabla[$k1]);
            }
        }

        return array_values($tabla)[0];
    }
}