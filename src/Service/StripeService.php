<?php

namespace App\Service;

use Stripe\StripeClient;

class StripeService
{
    private $stripe;

    public function __construct(string $stripeSecretKey)
    {
        $this->stripe = new StripeClient($stripeSecretKey);
    }

    public function createPaymentIntent(float $amount, string $description): \Stripe\PaymentIntent
    {
        return $this->stripe->paymentIntents->create([
            'amount' => (int) ($amount * 100), // Conversion en cents
            'currency' => 'eur',
            'description' => $description,
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);
    }
}