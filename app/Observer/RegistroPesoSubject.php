<?php
require_once __DIR__ . '/RegistroPeso.php';
require_once __DIR__ . '/IRegistroPesoObserver.php';
/**
 * RegistroPesoSubject
 *
 * Participante GoF: Subject (Observable)
 *
 * Mantiene la lista de observadores y los notifica
 * cada vez que se guarda un nuevo RegistroPeso.
 * No conoce qué hace cada observer.
 */
class RegistroPesoSubject
{
    /** @var IRegistroPesoObserver[] */
    private array $observadores = [];

    public function suscribir(IRegistroPesoObserver $observador): void
    {
        $this->observadores[spl_object_id($observador)] = $observador;
        echo "[Subject] ✔ Suscrito: " . get_class($observador) . "\n";
    }

    public function desuscribir(IRegistroPesoObserver $observador): void
    {
        unset($this->observadores[spl_object_id($observador)]);
        echo "[Subject] ✖ Desuscrito: " . get_class($observador) . "\n";
    }

    public function guardarRegistro(RegistroPeso $registro): void
    {
        echo "\n[Subject] Guardando registro "
            . "(id={$registro->id}, arete={$registro->animal->arete}, "
            . "peso={$registro->pesoKg} kg)...\n";

        $this->notificar($registro);
    }

    private function notificar(RegistroPeso $registro): void
    {
        echo "[Subject] Notificando a " . count($this->observadores) . " observador(es)...\n";
        foreach ($this->observadores as $observador) {
            $observador->onPesoRegistrado($registro);
        }
    }
}