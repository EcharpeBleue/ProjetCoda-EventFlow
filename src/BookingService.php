<?php

declare(strict_types=1);

final class BookingService
{   
    

    public function confirm(Booking $booking, string $paymentMethod = 'stripe'): float
    {
        $bookingValidator = [
            new ValidatorEmail(),
            new ValidatorQuantity(),
        ];
        foreach ($bookingValidator as $validator) {
            $validator->validate($booking);
        }

        $calculator = new BookingCalculator();
        $total = $calculator->calculateTotal($booking->items);
    
            //d'abord le VIP et apres le pass 3days


        $discountApplicator = [
            new DiscountVip(),
            new DiscountPass()
        ];

        foreach ($discountApplicator as $discount) {
            $total = $discount->applyDiscount($total, $booking);
        }

        // JP : Refactorisation à faire ici dans une classe dédiée
        $paymentStartedAt = hrtime(true);
        if ($paymentMethod === 'stripe') {
            $stripe = new StripeClient();
            $transactionId = $stripe->charge($total, (string) $booking->id);
            echo "PAYMENT {$transactionId}" . PHP_EOL;
            
        } elseif ($paymentMethod === 'payfast') {
            $payFastSdk = new PayFastSdk();
            $adapter = new AdapterPayFast($payFastSdk);
            $transactionId = $adapter->charge($total, (string) $booking->id);
            echo "PAYMENT {$transactionId}" . PHP_EOL;
        } else {
            throw new RuntimeException('Unknown payment method');
        }
        $paymentDurationMs = (hrtime(true) - $paymentStartedAt) / 1_000_000;
        echo "payement duration: " . number_format($paymentDurationMs, 2) . " ms" . PHP_EOL;
        $booking->status = 'confirmed';

        echo "SQL INSERT booking={$booking->id} total={$total} status={$booking->status}" . PHP_EOL;

        $emailService = new EmailService();
        $emailService->sendConfirmation($booking->customer->email, $booking->id);

        return $total;
    }
}
