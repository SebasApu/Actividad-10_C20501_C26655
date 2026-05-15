<?php

namespace App\Factory\Contracts;

use App\Factory\Models\Raza;

interface IRazaFactory
{
    public function create(string $nombreRaza): Raza;
}
