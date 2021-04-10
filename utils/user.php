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
