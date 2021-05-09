<?php

require_once __DIR__ . '/../utils/database.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

$line_items = [];

$db = getDatabaseConnection();

foreach ($_POST as $id => $item) {
    // Verify count is greater than 1
    $count = intval($item['count']);
    if ($count < 1) continue;

    // Get stocks
    $count_sql = "select count(*) as count from reference r join product p on reference = id_reference where uuid_reference = ? and state = 'in_stock' group by id_reference";
    $total = databaseFindOne($db, $count_sql, [$id])["count"];
    $count = min($count, $total);

    if ($count < 1) continue;

    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'unit_amount' => intval($item['value']) * 100,
            'product_data' => [
                'name' => $item['brand'] . ' ' . $item['name'],
                'images' => ["https://i.imgur.com/EHyR2nP.png"],
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