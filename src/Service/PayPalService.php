<?php

namespace App\Service;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\LiveEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest; // Ajoute cette ligne

class PayPalService
{
    private PayPalHttpClient $client;

    public function __construct(string $clientId, string $secret, string $mode)
    {
        $environment = $mode === 'sandbox'
            ? new SandboxEnvironment($clientId, $secret)
            : new LiveEnvironment($clientId, $secret);

        $this->client = new PayPalHttpClient($environment);
    }

    public function getClient(): PayPalHttpClient
    {
        return $this->client;
    }

    public function createOrder(float $amount)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "EUR",
                    "value" => number_format($amount, 2, '.', '')
                ]
            ]],
            "application_context" => [
                "cancel_url" => "https://ton-site.com/paiement-annule",
                "return_url" => "https://ton-site.com/paiement-reussi"
            ]
        ];

        // Exécution de la requête
        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $e) {
            // Gérer les erreurs si elles se produisent
            throw new \RuntimeException('Erreur lors de la création de la commande PayPal: ' . $e->getMessage());
        }
    }
}
