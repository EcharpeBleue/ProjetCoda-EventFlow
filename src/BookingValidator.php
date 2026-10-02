<?php
    declare(strict_types=1);

    interface BookingValidator
    {
        public function validate(Booking $booking): void;
    }
