<?php
function validateUser($tok): bool
{
    $token = new Token();
    $token->import($tok);
    return $token->validate();
}

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
