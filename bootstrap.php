<?php

declare(strict_types=1);

require_once __DIR__ . '/src/DiscountInterface.php';
require_once __DIR__ . '/src/Customer.php';
require_once __DIR__ . '/src/Ticket.php';
require_once __DIR__ . '/src/BookingItem.php';
require_once __DIR__ . '/src/Booking.php';
require_once __DIR__ . '/src/GatewayPayment.php';
require_once __DIR__ . '/src/StripeClient.php';
require_once __DIR__ . '/src/PayFastSdk.php';
require_once __DIR__ . '/src/EmailService.php';
require_once __DIR__ . '/src/SmsClient.php';
require_once __DIR__ . '/src/LoyaltyService.php';
require_once __DIR__ . '/src/AnalyticsClient.php';
require_once __DIR__ . '/src/BookingService.php';
require_once __DIR__ . '/src/BookingCalculator.php';
require_once __DIR__ . '/src/DiscountPass.php';
require_once __DIR__ . '/src/DiscountVip.php';
require_once __DIR__ . '/src/ValidatorBooking.php';
require_once __DIR__ . '/src/ValidatorEmail.php';
require_once __DIR__ . '/src/ValidatorQuantity.php';
require_once __DIR__ . '/src/BookingRepository.php';
require_once __DIR__ . '/src/AdapterPayFast.php';

// Axe d'amélioration ici : pour faciliter la scalabilité du projet, il serait intéressant de séparer chaque require_once afin d'établir clairement qui dépend de qui. Cela permettrait de mieux comprendre les relations entre les différentes classes et de faciliter la maintenance du code à long terme.