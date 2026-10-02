<?php

declare(strict_types=1);

final class Ticket
{
    public function __construct(
        public string $code,
        public string $label,
        public float $price
    ) {
        if (!is_finite($price) || $price <= 0) {
            throw new InvalidArgumentException('The ticket price must be greater than 0 euro .');
        }
    }
}
