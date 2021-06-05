<?php
include_once "Token.php";

function getToken(): ?Token
{
    $authorization = getallheaders()['Authorization'];
    $output = [];
    preg_match("/Bearer\s((.*)\.(.*)\.(.*))/", $authorization, $output);

    if (sizeof($output) === 0) return null;

    $token = new Token();
    $token->import($output[1]);

    return $token;
}

function verifyAccess(?string $method = NULL, ?bool $auth = NULL, ?string $type = null, ?string $token = NULL): ?int
{
    if (is_null($token))
        $token = getToken();

    // Mathod not allowed
    if (!is_null($method) && $_SERVER["REQUEST_METHOD"] !== $method)
        return 405;

    // Unauthorized
    if (!is_null($auth) && !$token->validate())
        return 401;

    // Forbidden
    if (!is_null($type) && $token->getPayload()["type"] !== $type)
        return 403;

    return NULL;
}
