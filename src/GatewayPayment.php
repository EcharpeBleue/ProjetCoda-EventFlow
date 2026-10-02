<?php

declare(strict_types=1);

interface GatewayPayment
{
    public function charge(float $amount, string $reference): string;
}