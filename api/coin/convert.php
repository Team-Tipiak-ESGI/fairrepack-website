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

$sql = "select coins, waiting_coins from user where uuid_user = ?";
$params = [$token->getPayload()["uuid"]];
$user = databaseFindOne($db, $sql, $params);

$toConvert = intval($user["waiting_coins"]);
$coins = intval($user["coins"]) + floor($toConvert / 10);
$toConvert = $toConvert % 10;

$update = "update user set coins = ?, waiting_coins = ? where uuid_user = ?";
$params = [$coins, $toConvert, $token->getPayload()["uuid"]];
databaseUpdate($db, $update, $params);

echo json_encode(["waiting_coins" => $toConvert, "coins" => $coins]);
