<?php

namespace App\Providers;

use App\Factory\Contracts\IRazaFactory;
use App\Factory\Factories\RazaFactory;
use App\Repository\Contracts\IAnimalRepository;
use App\Repository\Repositories\EloquentAnimalRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Factory: singleton, el mapa de razas no cambia en ejecución
        $this->app->singleton(IRazaFactory::class, RazaFactory::class);

        // Repository: bind de interfaz a implementación Eloquent
        $this->app->bind(IAnimalRepository::class, EloquentAnimalRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
