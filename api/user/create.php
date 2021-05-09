<?php

/**
 * User signup
 */

define("SECRET", $_SERVER["HTTP_SALT"] ?? "secret");

require_once __DIR__ . '/../../utils/database.php';
require_once __DIR__ . '/../../utils/UUIDv4.php';
require_once __DIR__ . '/../../utils/dao/user.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);
header("Content-Type: application/json");

$email = $_POST["email"];
$password = $_POST["password"];

if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false && strlen($password) >= 8) {
    $connection = getDatabaseConnection();
    $hashed_password = hash('sha256', $password . SECRET);
    $uuid = UUIDv4();

    $sql = "insert into `user` (uuid_user, email, password) values (?, ?, ?)";

    try {
        $id_user = databaseInsert($connection, $sql, [$uuid, $email, $hashed_password]);
    } catch (PDOException $e) {
        switch ($e->getCode()) {
            case 23000:
                http_response_code(409);
                die(json_encode(["error" => "Duplicate user."]));
            default:
                http_response_code(400);
                die(json_encode(["error" => $e->getMessage()]));
        }
    }

    $token = loginUser($email, $password);

    if (is_null($token)) {
        http_response_code(500); // Token should not be null
        die();
    }

    echo json_encode(["token" => $token->get()]);

    http_response_code(201);
} else {
    http_response_code(400);
}
