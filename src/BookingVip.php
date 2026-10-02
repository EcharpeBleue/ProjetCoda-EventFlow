<?php
declare(strict_types=1);
final class BookingVip
{
    public function applyDiscount(float $price, customer $customer, total $total): float
    {
        if ($customer->type === 'VIP') {

    if ($total < 100) {
        $total = $total * 0.95;
    } elseif ($total > 100 && $total< 300) {
        $total = $total * 0.90;
    } else {
        $total = $total * 0.85;
    }
}

return $total;

    }
} 