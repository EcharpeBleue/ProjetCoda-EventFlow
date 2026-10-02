<?php

declare(strict_types=1);

final class BookingService
{   
    

    public function confirm(Booking $booking, string $paymentMethod = 'stripe'): float
    {
        $bookingValidator = [
            new BookingEmail(),
            new BookingQuantity(),
        ];
        $bookingValidator = array_map(fn(BookingValidator $validator) => $validator->validate($booking), $bookingValidator);

        $calculator = new BookingCalculator();
        $total = $calculator->calculateTotal($booking->items);

        // Ancienne règle Pass 3 jours : remise fixe de 10 euros.
        // if ($booking->passType === '3days') {
        //     $total -= 10.0;
        // }

        $bookingVIP = new BookingVip();
        $total = $bookingVIP->applyDiscount($total, $booking->customer);

        if ($paymentMethod === 'stripe') {
            $stripe = new StripeClient();
            $transactionId = $stripe->charge($total);
            echo "PAYMENT {$transactionId}" . PHP_EOL;
        } elseif ($paymentMethod === 'payfast') {
            throw new RuntimeException('PayFast not implemented');
        } else {
            throw new RuntimeException('Unknown payment method');
        }

        // JP : Code onéreux, grande probabilité de refactorisation pour externaliser la logique de persistance dans une classe dédiée (BookingRepository) et ainsi séparer les responsabilités.

        $booking->status = 'confirmed';

        echo "SQL INSERT booking={$booking->id} total={$total} status={$booking->status}" . PHP_EOL;

        $emailService = new EmailService();
        $emailService->sendConfirmation($booking->customer->email, $booking->id);

        return $total;
    }
}
