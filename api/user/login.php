<?php

/**
 * User login, return a JWT
 */

require_once __DIR__ . '/../../utils/database.php';
require_once __DIR__ . '/../../utils/UUIDv4.php';
require_once __DIR__ . '/../../utils/Token.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);
header("Content-Type: application/json");

$email = $_POST["email"];
$password = $_POST["password"];

if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false && strlen($password) >= 8) {
    $connection = getDatabaseConnection();
    $hashed_password = hash('sha256', $password);

    $sql = "select uuid_user, language, user_type, username from `user`
            where email = ? and password = ?";

    $res = databaseFindOne($connection, $sql, [$email, $hashed_password]);

    if (!$res) {
        http_response_code(404);
        die();
    }

    $token = new Token();

    $token->create(
        ['alg' => 'HS256', 'typ' => 'JWT'],
        [
            'uuid_user' => $res['uuid_user'],
            'language' => $res['language'],
            'user_type' => $res['user_type'],
            'username' => $res['username'],
            'expiry' => time() + 3600
        ]
    );

    http_response_code(200);

    echo json_encode(["token" => $token->get()]);
} else {
    http_response_code(400);
}
