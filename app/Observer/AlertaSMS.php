<?php

/**
 * AlertaSMS
 *
 * Participante GoF: ConcreteObserver (NUEVO)
 *
 * Agregado sin modificar RegistroPesoSubject ni los demás observers.
 * Demuestra el principio Open/Closed:
 *   - Abierto para extensión  → se crea esta clase.
 *   - Cerrado para modificación → Subject y demás intactos.
 */
class AlertaSMS implements IRegistroPesoObserver
{
    public function __construct(
        private readonly string $numeroCelular
    ) {}

    public function onPesoRegistrado(RegistroPeso $registro): void
    {
        $mensaje = "BovWeight CR: {$registro->animal->arete} "
                 . "pesó {$registro->pesoKg} kg el {$registro->fechaHora}.";

        // En producción: Twilio::message($this->numeroCelular, $mensaje)
        echo "[AlertaSMS] 📱 SMS → {$this->numeroCelular}: \"{$mensaje}\"\n";
    }
}