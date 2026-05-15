<?php

/**
 * EstimadorPesoServiceTest
 *phpp
 * Pruebas unitarias del patrón Strategy.
 */
class EstimadorPesoServiceTest
{
    private int $pasadas = 0;
    private int $fallidas = 0;

    private array $datos = [
        'peso_referencia_kg'        => 400.0,
        'circunferencia_toracica_m' => 1.85,
        'raza'                      => 'Nelore',
        'meses_edad'                => 20,
    ];

    /** Test 1: YOLOv8 retorna resultado con confianza 94.5%. */
    public function test_yolov8_retorna_resultado_valido(): void
    {
        $servicio  = new EstimadorPesoService(new AlgoritmoYolov8());
        $resultado = $servicio->estimar($this->datos);

        $this->assert($resultado instanceof ResultadoEstimacion, "Retorna ResultadoEstimacion");
        $this->assert($resultado->pesoKg > 0,                   "Peso mayor a 0");
        $this->assert($resultado->metodoUsado === 'YOLOv8',      "Método = YOLOv8");
        $this->assert($resultado->confianzaPorcentaje === 94.5,  "Confianza = 94.5%");
    }

    /** Test 2: Regresión Lineal aplica la fórmula correcta. */
    public function test_regresion_lineal_retorna_resultado_valido(): void
    {
        $servicio  = new EstimadorPesoService(new AlgoritmoRegresionLineal());
        $resultado = $servicio->estimar($this->datos);

        $esperado = round(87.5 * 1.85 - 60, 2); // 101.88

        $this->assert($resultado instanceof ResultadoEstimacion,         "Retorna ResultadoEstimacion");
        $this->assert($resultado->pesoKg === $esperado,                  "Peso = {$esperado} kg");
        $this->assert($resultado->metodoUsado === 'Regresión Lineal',    "Método = Regresión Lineal");
    }

    /** Test 3: Tabla de Referencia interpola correctamente. */
    public function test_tabla_referencia_retorna_resultado_valido(): void
    {
        $servicio  = new EstimadorPesoService(new AlgoritmoTablaReferencia());
        $resultado = $servicio->estimar($this->datos);

        // Nelore meses=20 → entre 18(350) y 24(430): 350 + (2/6)*80 = 376.67
        $esperado = round(350 + (2 / 6) * 80, 2);

        $this->assert($resultado instanceof ResultadoEstimacion,           "Retorna ResultadoEstimacion");
        $this->assert($resultado->pesoKg === $esperado,                    "Peso = {$esperado} kg");
        $this->assert($resultado->metodoUsado === 'Tabla de Referencia',   "Método = Tabla de Referencia");
    }

    /** Test 4: Fallback YOLOv8 → TablaReferencia cuando el servicio falla. */
    public function test_fallback_yolov8_a_tabla_referencia(): void
    {
        $servicio = new EstimadorPesoService(new AlgoritmoYolov8(simularFallo: true));

        $resultado        = null;
        $capturoExcepcion = false;

        try {
            $servicio->estimar($this->datos);
        } catch (RuntimeException) {
            $capturoExcepcion = true;
            $servicio->setAlgoritmo(new AlgoritmoTablaReferencia());
            $resultado = $servicio->estimar($this->datos);
        }

        $this->assert($capturoExcepcion,                                    "Captura RuntimeException");
        $this->assert($resultado instanceof ResultadoEstimacion,            "Fallback retorna resultado");
        $this->assert($resultado->metodoUsado === 'Tabla de Referencia',    "Fallback usa TablaReferencia");
    }

    // ── Helpers ─────────────────────────────────────────────

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