<?php

/**
 * Entidad de dominio: Animal registrado en el rancho.
 */
class Animal
{
    public function __construct(
        public readonly int    $id,
        public readonly string $arete,
        public readonly string $raza,
        public readonly int    $ranchoId
    ) {}
}