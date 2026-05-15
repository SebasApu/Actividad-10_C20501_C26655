<?php

/**
 * ============================================================
 * IF7100 - Ingeniería del Software I
 * Lab: Catálogo de Patrones – EJERCICIO 3: OBSERVER
 * BovWeight CR – Eventos de RegistroPeso
 * ============================================================
 *
 * Archivos en esta carpeta:
 *   Animal.php
 *   RegistroPeso.php
 *   IRegistroPesoObserver.php
 *   RegistroPesoSubject.php
 *   NotificadorPropietario.php
 *   RecalculadorICC.php
 *   WebhookSenasa.php
 *   AlertaSMS.php
 *   RegistroPesoSubjectTest.php
 *   index.php  ← este archivo
 */

require_once __DIR__ . '/Animal.php';
require_once __DIR__ . '/RegistroPeso.php';
require_once __DIR__ . '/IRegistroPesoObserver.php';
require_once __DIR__ . '/RegistroPesoSubject.php';
require_once __DIR__ . '/NotificadorPropietario.php';
require_once __DIR__ . '/RecalculadorICC.php';
require_once __DIR__ . '/WebhookSenasa.php';
require_once __DIR__ . '/AlertaSMS.php';

// ════════════════════════════════════════════════════════════
// DEMO
// ════════════════════════════════════════════════════════════

echo str_repeat('═', 60) . "\n";
echo "PATRÓN OBSERVER – BovWeight CR\n";
echo str_repeat('═', 60) . "\n";

$subject = new RegistroPesoSubject();

// Suscribir los 3 observers iniciales
$subject->suscribir(new NotificadorPropietario('ganadero@ranchosanjose.cr'));
$subject->suscribir(new RecalculadorICC());
$subject->suscribir(new WebhookSenasa());

// Primer pesaje
$animal1   = new Animal(42, 'CR-0042', 'Brahman', 5);
$registro1 = new RegistroPeso(1, $animal1, 385.0, '2025-06-10T08:00:00', 'yolov8');
$subject->guardarRegistro($registro1);

// Agregar AlertaSMS sin tocar nada existente
echo "\n" . str_repeat('─', 60) . "\n";
echo "[Cliente] Agregando AlertaSMS (nuevo observer)...\n";
echo "          Subject y demás observers: sin modificar.\n";
echo str_repeat('─', 60) . "\n";

$subject->suscribir(new AlertaSMS('+50688001234'));

// Segundo pesaje – llega a 4 observers
$animal2   = new Animal(17, 'CR-0017', 'Nelore', 5);
$registro2 = new RegistroPeso(2, $animal2, 412.5, '2025-06-10T09:15:00', 'bascula');
$subject->guardarRegistro($registro2);

// ════════════════════════════════════════════════════════════
// PRUEBAS UNITARIAS
// ════════════════════════════════════════════════════════════

echo "\n" . str_repeat('═', 60) . "\n";
echo "PRUEBAS UNITARIAS\n";
echo str_repeat('═', 60) . "\n";

require_once __DIR__ . '/RegistroPesoSubjectTest.php';
(new RegistroPesoSubjectTest())->run();