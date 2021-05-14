<?php

/**
 * User login, return a JWT
 */

define("SECRET", $_SERVER["HTTP_SALT"] ?? "secret");

require_once __DIR__ . '/../../utils/database.php';
require_once __DIR__ . '/../../utils/UUIDv4.php';
require_once __DIR__ . '/../../utils/Token.php';
require_once __DIR__ . '/../../utils/dao/user.php';
require_once __DIR__ . '/../../utils/user.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);
header("Content-Type: application/json");

$email = $_POST["email"];
$password = $_POST["password"];

$token = getToken();

if ($token && $token->validate()) {
    $token->renew(3600);
    echo json_encode(["token" => $token->get()]);
} else if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false && strlen($password) >= 8) {
    $token = loginUser($email, $password);

    if (is_null($token)) {
        http_response_code(404);
        die();
    }

    echo json_encode(["token" => $token->get()]);
} else {
    http_response_code(400);
}
