<?php

/**
 * Entidad de dominio: Registro de un pesaje de un animal.
 * Es el objeto que viaja del Subject a todos los Observers.
 */
class RegistroPeso
{
    public function __construct(
        public readonly int    $id,
        public readonly Animal $animal,
        public readonly float  $pesoKg,
        public readonly string $fechaHora,
        public readonly string $metodoCaptura
    ) {}
}