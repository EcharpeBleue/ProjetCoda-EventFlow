<?php
declare(strict_types=1);
final class ValidatorQuantity implements ValidatorBooking
    {
    public function validate(Booking $booking): void
    {
    if($booking->items === []){
        throw new RuntimeException('empty Booking');
        }    
    foreach ($booking->items as $item) {
        if ($item->quantity <= 0) {
            throw new RuntimeException('Invalid item quantity');
            }
        }
    }

    }