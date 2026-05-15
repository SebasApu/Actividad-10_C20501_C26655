<?php

/**
 * NotificadorPropietario
 *
 * Participante GoF: ConcreteObserver
 *
 * Envía un email al propietario del rancho cuando
 * se registra un nuevo peso.
 */
class NotificadorPropietario implements IRegistroPesoObserver
{
    public function __construct(
        private readonly string $emailPropietario
    ) {}

    public function onPesoRegistrado(RegistroPeso $registro): void
    {
        // En producción: Mail::to($this->emailPropietario)->send(new PesoRegistradoMail($registro))
        echo "[NotificadorPropietario] 📧 Email → {$this->emailPropietario}: "
            . "Nuevo peso de {$registro->animal->arete} = {$registro->pesoKg} kg\n";
    }
}