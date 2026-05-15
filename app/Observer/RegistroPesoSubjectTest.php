<?php

/**
 * ObservadorSpy
 *
 * Mock manual para pruebas unitarias.
 * Registra cuántas veces fue llamado y qué registro recibió.
 *
 * En PHPUnit real sería:
 *   $mock = $this->createMock(IRegistroPesoObserver::class);
 *   $mock->expects($this->once())->method('onPesoRegistrado');
 */
class ObservadorSpy implements IRegistroPesoObserver
{
    public int $vecesCalled = 0;
    public ?RegistroPeso $ultimoRegistro = null;

    public function onPesoRegistrado(RegistroPeso $registro): void
    {
        $this->vecesCalled++;
        $this->ultimoRegistro = $registro;
    }
}

/**
 * RegistroPesoSubjectTest
 *
 * Pruebas unitarias del patrón Observer.
 */
class RegistroPesoSubjectTest
{
    private int $pasadas = 0;
    private int $fallidas = 0;

    /** Test 1: Todos los observers suscritos reciben exactamente 1 llamada. */
    public function test_todos_los_observadores_suscritos_reciben_la_llamada(): void
    {
        $subject = new RegistroPesoSubject();
        $spy1 = new ObservadorSpy();
        $spy2 = new ObservadorSpy();
        $spy3 = new ObservadorSpy();

        $subject->suscribir($spy1);
        $subject->suscribir($spy2);
        $subject->suscribir($spy3);

        $registro = $this->registroFake(1, 420.5);
        $subject->guardarRegistro($registro);

        foreach ([$spy1, $spy2, $spy3] as $i => $spy) {
            $n = $i + 1;
            $this->assert($spy->vecesCalled === 1,       "Spy{$n} llamado 1 vez");
            $this->assert($spy->ultimoRegistro === $registro, "Spy{$n} recibe el registro correcto");
        }
    }

    /** Test 2: Un observer desuscrito NO recibe la notificación. */
    public function test_observador_desuscrito_no_recibe_notificacion(): void
    {
        $subject      = new RegistroPesoSubject();
        $spyActivo    = new ObservadorSpy();
        $spyDesuscrito = new ObservadorSpy();

        $subject->suscribir($spyActivo);
        $subject->suscribir($spyDesuscrito);
        $subject->desuscribir($spyDesuscrito);

        $subject->guardarRegistro($this->registroFake(2, 310.0));

        $this->assert($spyActivo->vecesCalled    === 1, "Spy activo recibe 1 llamada");
        $this->assert($spyDesuscrito->vecesCalled === 0, "Spy desuscrito no recibe llamadas");
    }

    /** Test 3: Sin observers, guardar no lanza ninguna excepción. */
    public function test_sin_observadores_no_lanza_excepcion(): void
    {
        $subject = new RegistroPesoSubject();
        $lanzo   = false;

        try {
            $subject->guardarRegistro($this->registroFake(3, 280.0));
        } catch (\Throwable) {
            $lanzo = true;
        }

        $this->assert(! $lanzo, "Sin observers no lanza excepción");
    }

    // ── Helpers ─────────────────────────────────────────────

    private function registroFake(int $id, float $pesoKg): RegistroPeso
    {
        $animal = new Animal(1, 'CR-TEST', 'Brahman', 5);
        return new RegistroPeso($id, $animal, $pesoKg, '2025-06-15T10:00:00', 'bascula');
    }

    private function assert(bool $condicion, string $desc): void
    {
        if ($condicion) {
            echo "  ✅ PASS: {$desc}\n";
            $this->pasadas++;
        } else {
            echo "  ❌ FAIL: {$desc}\n";
            $this->fallidas++;
        }
    }

    public function run(): void
    {
        foreach (get_class_methods($this) as $m) {
            if (str_starts_with($m, 'test_')) {
                echo "\n── {$m} ──\n";
                $this->$m();
            }
        }
        echo "\n" . str_repeat('─', 50) . "\n";
        echo "Resultado: {$this->pasadas} pasadas, {$this->fallidas} fallidas.\n";
        echo str_repeat('─', 50) . "\n";
    }
}