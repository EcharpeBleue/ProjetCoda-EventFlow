<?php
    declare(strict_types=1);

    interface ValidatorBooking
    {
        public function validate(Booking $booking): void;
    }
