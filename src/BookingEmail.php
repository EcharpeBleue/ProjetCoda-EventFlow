<?php
declare(strict_types=1);
    final class BookingEmail implements BookingValidator
    {
    public function validate(Booking $booking): void
    {
        if (!filter_var($booking->customer->email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Invalid email');
        }
    }

    }