<?php

/**
 * ============================================================
 * IF7100 - Ingeniería del Software I
 * Lab: Catálogo de Patrones – EJERCICIO 4: STRATEGY
 * BovWeight CR – Algoritmos de Estimación de Peso
 * ============================================================
 *
 * Archivos en esta carpeta:
 *   ResultadoEstimacion.php
 *   IAlgoritmoEstimacion.php
 *   AlgoritmoYolov8.php
 *   AlgoritmoRegresionLineal.php
 *   AlgoritmoTablaReferencia.php
 *   EstimadorPesoService.php
 *   EstimadorPesoServiceTest.php
 *   index.php  ← este archivo
 */

require_once __DIR__ . '/ResultadoEstimacion.php';
require_once __DIR__ . '/IAlgoritmoEstimacion.php';
require_once __DIR__ . '/AlgoritmoYolov8.php';
require_once __DIR__ . '/AlgoritmoRegresionLineal.php';
require_once __DIR__ . '/AlgoritmoTablaReferencia.php';
require_once __DIR__ . '/EstimadorPesoService.php';

$datos = [
    'peso_referencia_kg'        => 400.0,
    'circunferencia_toracica_m' => 1.85,
    'raza'                      => 'Nelore',
    'meses_edad'                => 20,
];

echo str_repeat('═', 60) . "\n";
echo "PATRÓN STRATEGY – BovWeight CR\n";
echo str_repeat('═', 60) . "\n";

// Estrategia 1: YOLOv8
echo "\n--- Estrategia: YOLOv8 ---\n";
$servicio = new EstimadorPesoService(new AlgoritmoYolov8());
echo "Resultado → " . $servicio->estimar($datos) . "\n";

// Estrategia 2: Regresión Lineal
echo "\n--- Estrategia: Regresión Lineal ---\n";
$servicio->setAlgoritmo(new AlgoritmoRegresionLineal());
echo "Resultado → " . $servicio->estimar($datos) . "\n";

// Estrategia 3: Tabla de Referencia
echo "\n--- Estrategia: Tabla de Referencia ---\n";
$servicio->setAlgoritmo(new AlgoritmoTablaReferencia());
echo "Resultado → " . $servicio->estimar($datos) . "\n";

// Fallback en tiempo de ejecución
echo "\n" . str_repeat('─', 60) . "\n";
echo "DEMO FALLBACK: YOLOv8 falla → Tabla de Referencia\n";
echo str_repeat('─', 60) . "\n";

$servicioFallback = new EstimadorPesoService(new AlgoritmoYolov8(simularFallo: true));

try {
    $servicioFallback->estimar($datos);
} catch (RuntimeException $e) {
    echo "⚠  {$e->getMessage()}\n";
    $servicioFallback->setAlgoritmo(new AlgoritmoTablaReferencia());
    echo "Resultado (fallback) → " . $servicioFallback->estimar($datos) . "\n";
}

// ════════════════════════════════════════════════════════════
// PRUEBAS UNITARIAS
// ════════════════════════════════════════════════════════════

echo "\n" . str_repeat('═', 60) . "\n";
echo "PRUEBAS UNITARIAS\n";
echo str_repeat('═', 60) . "\n";

require_once __DIR__ . '/EstimadorPesoServiceTest.php';
(new EstimadorPesoServiceTest())->run();

//php app/Strategy/index.php