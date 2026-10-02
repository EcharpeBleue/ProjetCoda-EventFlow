<?php

declare(strict_types=1);

interface DiscountInterface
{
    public function applyDiscount(float $total, Booking $booking): float;
}