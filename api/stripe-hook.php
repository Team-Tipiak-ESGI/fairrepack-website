<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/stripe-php/init.php');
\Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    echo '⚠️  Webhook error while parsing basic request.';
    http_response_code(400);
    exit();
}

function handlePaymentIntentSucceeded($paymentIntent) {
    require_once __DIR__ . '/../utils/database.php';
    $db = getDatabaseConnection();

    // Get products
    $sql = "select product from payment where id_intent = ?";
    $products = databaseSelectAll($db, $sql, [$paymentIntent->id], PDO::FETCH_COLUMN);

    foreach ($products as $product) {
        databaseUpdate($db, "update product set state = 'sold' where id_product = ?", [$product]);
    }
}

// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
        $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
        // Then define and call a method to handle the successful payment intent.
        handlePaymentIntentSucceeded($paymentIntent);
        break;
    case 'payment_method.attached':
        $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
        // Then define and call a method to handle the successful attachment of a PaymentMethod.
        // handlePaymentMethodAttached($paymentMethod);
        break;
    default:
        // Unexpected event type
        echo 'Received unknown event type';
}

http_response_code(200);