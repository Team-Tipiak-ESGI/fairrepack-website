<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated
$token = getToken();
if (!$token->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$db = getDatabaseConnection();

$uuid_user = $token->getPayload()["uuid"];

$sql = "select coins, waiting_coins from user where uuid_user = ?";
$params = [$uuid_user];
$user = databaseFindOne($db, $sql, $params);

$user_coins = intval($user["coins"]);

$association = $_POST["uuid"];
$coins_to_spend = intval($_POST["coins"]);

if ($coins_to_spend > $user_coins) {
    // Cannot spend coins
    http_response_code(400);
    die();
}

$update = "update association set coin = ? where uuid_association = ?";
$params = [$coins_to_spend, $association];
databaseUpdate($db, $update, $params);

$update = "update user set coins = ? where uuid_user = ?";
$params = [$user_coins - $coins_to_spend, $uuid_user];
databaseUpdate($db, $update, $params);

http_response_code(204);
