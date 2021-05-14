<?php

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../UUIDv4.php';
require_once __DIR__ . '/../Token.php';

function loginUser($email, $password): ?Token
{
    $connection = getDatabaseConnection();
    $hashed_password = hash('sha256', $password . SECRET);

    $sql = "select id_user, uuid_user, language, user_type, username from `user`
            where email = ? and password = ?";

    $res = databaseFindOne($connection, $sql, [$email, $hashed_password]);

    if (!$res) return null;

    $token = new Token();

    $token->create(
        ['alg' => 'HS256', 'typ' => 'JWT'],
        [
            // This is mandatory, used by the client to make identified requests
            // If not provided, the requests are anonymous
            'uuid' => $res['uuid_user'],
            'lang' => $res['language'],
            'type' => $res['user_type'],
            'username' => $res['username'],

            // This is mandatory, used by the server for validating the token
            //'expiry' => time() + 3600,
            'expiry' => time() + 3600,
        ]
    );

    http_response_code(200);

    try {
        // Log connections
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $remote_address = $_SERVER['REMOTE_ADDR'];

        $sql = "insert into `history_useragent` (useragent) values (?) ON DUPLICATE KEY UPDATE id_history_useragent = LAST_INSERT_ID(id_history_useragent)";
        $useragent_id = databaseInsert($connection, $sql, [$useragent]);

        $sql = "insert into `history_ip` (ip) values (?) ON DUPLICATE KEY UPDATE id_history_ip = LAST_INSERT_ID(id_history_ip)";
        $ip_id = databaseInsert($connection, $sql, [$remote_address]);

        $sql = "insert into `history_login` (useragent, ip, user) values (?, ?, ?)";
        $history_id = databaseInsert($connection, $sql, [$useragent_id, $ip_id, $res['id_user']]);
    } catch (PDOException $e) {
    }

    return $token;
}