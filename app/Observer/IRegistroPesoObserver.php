<?php

/**
 * IRegistroPesoObserver
 *
 * Participante GoF: Observer (interfaz)
 *
 * Contrato que deben implementar todos los suscriptores
 * del evento "peso registrado".
 */
interface IRegistroPesoObserver
{
    public function onPesoRegistrado(RegistroPeso $registro): void;
}