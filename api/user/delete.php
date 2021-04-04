<?php

require_once __DIR__ . '/../../utils/database.php';
require_once __DIR__ . '/../../utils/UUIDv4.php';
require_once __DIR__ . '/../../utils/Token.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);
header("Content-Type: application/json");

$token = new Token();
$token->import($_POST["token"]);

if ($token->validate()) {
    $connection = getDatabaseConnection();

    $payload = $token->getPayload();

    $sql = "DELETE FROM user WHERE uuid_user = ?";

    $success = databaseDelete($connection, $sql, [$payload['uuid']]);

    if ($success > 0) {
        http_response_code(204); // NO_CONTENT
    } else {
        http_response_code(400); // BAD_REQUEST
    }
}
