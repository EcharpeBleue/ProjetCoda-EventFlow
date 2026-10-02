<?php
declare(strict_types=1);
final class BookingQuantity implements BookingValidator
    {
    public function validate(Booking $booking): void
    {
        if ($booking->quantity <= 0) {
            throw new RuntimeException('Invalid quantity');
        }
    }

    }