<?php

declare(strict_types=1);

final class AdapterPayFast implements GatewayPayment
{
    private PayFastSdk $payFastSdk;

    public function __construct(PayFastSdk $payFastSdk)
    {
        $this->payFastSdk = $payFastSdk;
    }

    public function charge(float $amount, string $reference): string
    {
        $payload = [
            'reference' => $reference,
            // pour convertir le montant en centimes, on multiplie par 100 et on force le cast de type en int avec () devant la variable.
            'amount_cents' => (int)round(($amount * 100)),
            'currency' => 'EUR',
        ];

        $response = $this->payFastSdk->executePayment($payload);

        if (!$response['success']) {
            throw new RuntimeException('Payment failed');
        }

        return $response['transaction_id'];
    }
}