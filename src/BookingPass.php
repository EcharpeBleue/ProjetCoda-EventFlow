<?php
declare(strict_types=1);

//si on prend un pass de 3 jour on benefici d'une remise de 20 euro

final class BookingPass
{
public function apply(total $total , BookingPass $bookingPass): float
{
    if ($bookingPass->getDuration() === 3) {
        return $bookingPass->getPrice() - 20;
    }

    return $bookingPass->getPrice();
}
}