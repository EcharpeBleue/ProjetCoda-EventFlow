<?php
declare(strict_types=1);
final class DiscountVip implements DiscountInterface
{
    public function applyDiscount( float $total , Booking $booking): float
    {
        if ($booking->customer->type === 'vip') {

    if ($total < 100) {
        $total = $total * 0.95;
    } elseif ($total >= 100 && $total < 300) {
        $total = $total * 0.90;
    } else {
        $total = $total * 0.85;
    }
}

return $total;

    }
} 