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


        $DiscountVip = new DiscountVip();
        $total = $DiscountVip->applyDiscount($total, $booking->customer);

        $DiscountPass = new DiscountPass();
        $total = $DiscountPass->applyDiscount($total, $booking);


        // JP : Refactorisation à faire ici pour utiliser un repository et ne pas faire d'echo dans le service
        if ($paymentMethod === 'stripe') {
            $stripe = new StripeClient();
            $transactionId = $stripe->charge($total);
            echo "PAYMENT {$transactionId}" . PHP_EOL;
        } elseif ($paymentMethod === 'payfast') {
            $payFastSdk = new PayFastSdk();
            $adapter = new AdapterPayFast($payFastSdk);
            $transactionId = $adapter->charge($total);
            echo "PAYMENT {$transactionId}" . PHP_EOL;
        } else {
            throw new RuntimeException('Unknown payment method');
        }

        $booking->status = 'confirmed';

        echo "SQL INSERT booking={$booking->id} total={$total} status={$booking->status}" . PHP_EOL;

        $emailService = new EmailService();
        $emailService->sendConfirmation($booking->customer->email, $booking->id);

        return $total;
    }
}
