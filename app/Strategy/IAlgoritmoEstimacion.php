<?php

/**
 * IAlgoritmoEstimacion
 *
 * Participante GoF: Strategy (interfaz)
 *
 * Contrato común para todos los algoritmos de estimación.
 * EstimadorPesoService solo conoce esta interfaz.
 */
interface IAlgoritmoEstimacion
{
    /**
     * @param  array $datosEntrada  Datos del animal / imagen / medidas.
     * @return ResultadoEstimacion  Resultado inmutable.
     * @throws RuntimeException     Si el servicio externo no está disponible.
     */
    public function ejecutar(array $datosEntrada): ResultadoEstimacion;
}