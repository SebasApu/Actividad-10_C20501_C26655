<?php

/**
 * WebhookSenasa
 *
 * Participante GoF: ConcreteObserver
 *
 * Dispara un webhook al sistema de SENASA con los datos
 * del pesaje recién registrado.
 */
class WebhookSenasa implements IRegistroPesoObserver
{
    private const ENDPOINT = 'https://api.senasa.go.cr/bovweight/pesos';

    public function onPesoRegistrado(RegistroPeso $registro): void
    {
        $payload = json_encode([
            'arete'      => $registro->animal->arete,
            'raza'       => $registro->animal->raza,
            'peso_kg'    => $registro->pesoKg,
            'fecha_hora' => $registro->fechaHora,
            'metodo'     => $registro->metodoCaptura,
        ]);

        // En producción: Http::post(self::ENDPOINT, json_decode($payload, true))
        echo "[WebhookSenasa] 🌐 POST → " . self::ENDPOINT . "\n"
            . "               Payload: {$payload}\n";
    }
}