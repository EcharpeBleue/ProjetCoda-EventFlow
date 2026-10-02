<?php
    declare(strict_types=1);

    final class BookingValidator
    {
        public function validate(booking $booking): void
        {
            if (count($booking->items) === 0) {
                throw new InvalidArgumentException('empty booking');
            }
            if (!filter_var($booking->email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('invalid email');
            }
            foreach ($booking->items as $item) {
                if ($item->quantity <= 0) {
                    throw new InvalidArgumentException('invalid quantity');
                }
            }
        }
    }

    // JP : Je suggère de créer une interface InvalidBookingException pour regrouper ces exceptions et les gérer de manière plus cohérente. Cela permettrait de mieux structurer le code et de faciliter la maintenance à long terme.
