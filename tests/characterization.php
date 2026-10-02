<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/TestRunner.php';

$tests = new TestRunner();

function createBooking(
    string $customerType = 'standard',
    string $passType = 'day',
    float $price = 50.0,
    int $quantity = 1,
    ?string $phone = '0600000000'
): Booking {
    $customer = new Customer(1, 'test@example.com', $phone, $customerType);
    $ticket = new Ticket('TEST', 'Ticket test', $price);
    $booking = new Booking(1, $customer, $passType);
    $booking->addItem(new BookingItem($ticket, $quantity));
    return $booking;
}

ob_start();
$service = new BookingService();

$standard = createBooking('standard', 'day', 50.0, 2);
$standardTotal = $service->confirm($standard, 'stripe');
$tests->near(100.0, $standardTotal, 'standard customer keeps initial total');
$tests->same('confirmed', $standard->status, 'booking becomes confirmed');

$vip = createBooking('vip', 'day', 50.0, 2);
$vipTotal = $service->confirm($vip, 'stripe');
$tests->near(90.0, $vipTotal, 'VIP rule gives 10 percent discount');

$threeDays = createBooking('standard', '3days', 60.0, 2);
$threeDaysTotal = $service->confirm($threeDays, 'stripe');
$tests->near(100.0, $threeDaysTotal, 'Three day pass discount is 20 euros');

$fastPay = createBooking('standard', 'day', 50.0, 2);
$fastPayTotal = $service->confirm($fastPay, 'payfast');
$tests->near(100.0, $fastPayTotal, 'lPayFast payment method works.');

$discountVipwith300euros = createBooking('vip', 'day', 150.0, 2);
$discountVipwith300eurosTotal = $service->confirm($discountVipwith300euros, 'stripe');
$tests->near(255.0, $discountVipwith300eurosTotal, 'VIP rule gives 15 percent discount for total >= 300 euros');

$discountVipwith125euros = createBooking('vip', 'day', 125.0, 1);
$discountVipwith125eurosTotal = $service->confirm($discountVipwith125euros, 'stripe');
$tests->near(112.5, $discountVipwith125eurosTotal, 'VIP rule gives 10 percent discount for total >= 100 euros and < 300 euros');

$discountVipwith99euros = createBooking('vip', 'day', 99.0, 1);
$discountVipwith99eurosTotal = $service->confirm($discountVipwith99euros, 'stripe');
$tests->near(94.05, $discountVipwith99eurosTotal, 'VIP rule gives 5 percent discount for total < 100 euros');

ob_end_clean();
$tests->summary();
