<?php

declare(strict_types=1);

final class StripeClient implements GatewayPayment
{
    public function charge(float $amount, string $reference): string
    {
        if ($amount <= 0) {
            throw new RuntimeException('Invalid amount');
        }

        return 'stripe_' . number_format($amount, 2, '.', '');
    }
}
