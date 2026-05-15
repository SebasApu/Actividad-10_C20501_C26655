<?php

use Illuminate\Support\Facades\Route;
use App\Factory\Contracts\IRazaFactory;
use App\Repository\Contracts\IAnimalRepository;
use App\Repository\Models\Animal;

// ─── PRUEBAS PATRÓN FACTORY ───────────────────────────────────────────────────

// Prueba 1: crear una raza válida
Route::get('/factory/crear/{raza}', function (string $raza, IRazaFactory $factory) {
    $instancia = $factory->create($raza);

    return response()->json([
        'patron'       => 'Factory',
        'raza_pedida'  => $raza,
        'clase_creada' => get_class($instancia),
        'nombre'       => $instancia->getNombre(),
        'peso_promedio'=> $instancia->getPesoPromedioKg() . ' kg',
        'rango_peso'   => $instancia->getRangoPesoKg(),
        'mejoramiento' => $instancia->esAptaMejoramientoGenetico(),
        'descripcion'  => $instancia->describir(),
    ]);
});

// Prueba 2: intentar una raza no registrada (debe lanzar excepción)
Route::get('/factory/invalida', function (IRazaFactory $factory) {
    try {
        $factory->create('Angus');
        return response()->json(['resultado' => 'creado (no debería llegar aquí)']);
    } catch (\InvalidArgumentException $e) {
        return response()->json([
            'patron'  => 'Factory',
            'error'   => $e->getMessage(),
            'resultado' => 'Excepción capturada correctamente',
        ]);
    }
});

// Prueba 3: ver todas las razas disponibles
Route::get('/factory/razas', function (IRazaFactory $factory) {
    return response()->json([
        'patron'           => 'Factory',
        'razas_disponibles' => $factory->getRazasDisponibles(),
    ]);
});


// ─── PRUEBAS PATRÓN REPOSITORY ────────────────────────────────────────────────

// Prueba 4: insertar un animal de prueba
Route::get('/repository/crear', function (IAnimalRepository $repo) {
    $animal = Animal::firstOrNew(['arete' => 'CR-2024-00001']);
    $animal->rancho_id        = 1;
    $animal->raza             = 'Brahman';
    $animal->sexo             = 'macho';
    $animal->fecha_nacimiento = '2022-03-15';
    $animal->peso_kg          = 480.0;

    $repo->save($animal);

    return response()->json([
        'patron'    => 'Repository',
        'accion'    => 'save()',
        'resultado' => $animal->wasRecentlyCreated ? 'Animal creado' : 'Animal actualizado',
        'animal'    => $animal,
    ]);
});

// Prueba 5: buscar por arete
Route::get('/repository/buscar/{arete}', function (string $arete, IAnimalRepository $repo) {
    $animal = $repo->findByArete($arete);

    return response()->json([
        'patron'  => 'Repository',
        'accion'  => 'findByArete()',
        'arete'   => $arete,
        'encontrado' => $animal !== null,
        'animal'  => $animal,
    ]);
});

// Prueba 6: listar todos los animales de un rancho
Route::get('/repository/rancho/{id}', function (int $id, IAnimalRepository $repo) {
    $animales = $repo->findAllByRancho($id);

    return response()->json([
        'patron'   => 'Repository',
        'accion'   => 'findAllByRancho()',
        'rancho_id' => $id,
        'total'    => count($animales),
        'animales' => $animales,
    ]);
});

// Prueba 7: eliminar un animal por ID
Route::get('/repository/eliminar/{id}', function (int $id, IAnimalRepository $repo) {
    $repo->delete($id);

    return response()->json([
        'patron'    => 'Repository',
        'accion'    => 'delete()',
        'resultado' => "Animal con ID {$id} eliminado",
    ]);
});

Route::get('/', function () {
    return view('welcome');
});
