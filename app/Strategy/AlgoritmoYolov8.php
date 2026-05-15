<?php
/**
 * AlgoritmoYolov8
 *
 * Participante GoF: ConcreteStrategy
 *
 * Envía la imagen al microservicio YOLOv8 y retorna
 * el peso estimado por visión computacional.
 *
 * Lanza RuntimeException si el servicio no responde,
 * lo que permite al cliente activar un fallback.
 */

require_once __DIR__ . '/ResultadoEstimacion.php';
require_once __DIR__ . '/IAlgoritmoEstimacion.php';

class AlgoritmoYolov8 implements IAlgoritmoEstimacion
{
    
    private const ENDPOINT = 'http://yolov8-service:8000/estimar';

    public function __construct(
        private readonly bool $simularFallo = false
    ) {}

    public function ejecutar(array $datosEntrada): ResultadoEstimacion
    {
        echo "[YOLOv8] Enviando imagen a " . self::ENDPOINT . "...\n";

        if ($this->simularFallo) {
            throw new RuntimeException("[YOLOv8] Servicio no disponible (timeout).");
        }

        // En producción: $response = Http::post(self::ENDPOINT, $datosEntrada)
        $peso = $datosEntrada['peso_referencia_kg'] * 1.02;
        echo "[YOLOv8] Respuesta recibida.\n";

        return new ResultadoEstimacion(
            pesoKg:              round($peso, 2),
            confianzaPorcentaje: 94.5,
            metodoUsado:         'YOLOv8'
        );
    }
}