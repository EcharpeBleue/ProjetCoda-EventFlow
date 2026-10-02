<?php
declare(strict_types=1);

//si on prend un pass de 3 jour on benefici d'une remise de 20 euro

final class DiscountPass
{
public function applyDiscount(float $total , Booking $booking): float
{
    if ($booking->passType === '3days') {
        return $total - 20.00;
    }

    return $total;
}
}