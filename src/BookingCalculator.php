<?php
declare(strict_types=1);

final class BookingCalculator
{
    public function calculateTotal(array $items): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item->ticket->price * $item->quantity;
        }
        return $total;
    }
}