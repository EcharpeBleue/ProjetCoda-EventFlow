<?php

declare(strict_types=1);

final class BookingService
{   
    public function __construct(
        //ici le bookingValidator sert à valider les données du booking avant de procéder à la confirmation. 
        private BookingValidator $bookingValidator, 
        //le bookingRepository est responsable de la persistance des données du booking dans la base de données.
        private BookingRepository $bookingRepository,

    ){}

    public function confirm(Booking $booking, string $paymentMethod = 'stripe'): float
    {
        if (count($booking->items) === 0) {
            throw new RuntimeException('Empty booking');
        }

        if (!filter_var($booking->customer->email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Invalid email');
        }
    
        // JP: ^^ 2 throw new RuntimeException -> désuet, refactoring à faire pour les remplacer par des classes dédiées (InvalidBookingException, InvalidEmailException, etc.)
        // JP : Une interface pourrait permettre de regrouper ces exceptions et de les gérer de manière plus cohérente.
        // JP : Une interface InvalidException ?

        $total = 0.0;

        foreach ($booking->items as $item) {
            if ($item->quantity <= 0) {
                throw new RuntimeException('Invalid quantity');
            }

            $total += $item->ticket->price * $item->quantity;
        }

        // JP : Ancienne règle de calcul du total, à refactoriser pour externaliser la logique de calcul dans une classe dédiée (BookingCalculator) et ainsi séparer les responsabilités.

        // Ancienne règle VIP : remise fixe de 10 %.
        if ($booking->customer->type === 'vip') {
            $total *= 0.90;
        }

        // JP : Ancienne règle VIP : remise fixe de 10%. Etant donnée que cette fonctionnalité est amenée à évoluer, je suggère de créer une classe dédiée.

        // Ancienne règle Pass 3 jours : remise fixe de 10 euros.
        if ($booking->passType === '3days') {
            $total -= 10.0;
        }

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
