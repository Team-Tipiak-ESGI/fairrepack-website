<?php

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/dao/product.php';
require_once __DIR__ . '/../utils/dao/reference.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

$line_items = [];

$db = getDatabaseConnection();

foreach ($_POST as $id => $count) {
    // Verify count is greater than 1
    $count = intval($count);
    if ($count < 1) continue;

    // Get product
    $product = getProductByUUID($id);

    // If product is in stock
    if ($product["state"] === "in_stock") continue;

    // Get reference (for name and brand)
    $reference = getReferenceByUUID($product["uuid_reference"]);

    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'unit_amount' => intval($product["last_price"]) * 100,
            'product_data' => [
                'name' => $reference["brand"] . ' ' . $reference["name"],
                'images' => getProductsImageUrls($id),
            ],
        ],
        'quantity' => max($count, 1),
    ];
}

if (sizeof($line_items) === 0) {
    http_response_code(400);
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/stripe-php/init.php');
\Stripe\Stripe::setApiKey('sk_test_51Iom4bHzfyqVGMdc0yNQeFcjbjFgh10Dnh3C6kGfGbxq6MBLbYdIttB50rsLiWrZotGTdS8kNnf5IkdJl22KJhaw00aG61SQRu');

header('Content-Type: application/json');

$DOMAIN = "http://" . ($_SERVER["SERVER_NAME"] ?? "fairrepack.sagliss.industries");

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => $DOMAIN . '/cart.php',
    'cancel_url' => $DOMAIN . '/cart.php',
]);

echo json_encode(['id' => $checkout_session->id]);