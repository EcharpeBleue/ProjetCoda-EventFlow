<?php
    declare(strict_types=1);

final class BookingRepository
{
    public function save (Booking $booking, float $total): void {
        echo "Booking saved with total: $total";
    }
}