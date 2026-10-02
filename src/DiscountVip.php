<?php
declare(strict_types=1);
final class DiscountVip
{
    public function applyDiscount( float $total , customer $customer): float
    {
        if ($customer->type === 'vip') {

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