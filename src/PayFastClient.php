<?php

declare(strict_types=1);

final class PayFastClient implements GatewayPayment
{
    public function charge(float $amount): string
    {
        if ($amount <= 0) {
            throw new RuntimeException('Invalid amount');
        }

        return 'payfast_' . number_format($amount, 2, '.', '');
    }
}