<?php
function validateUser($tok): bool
{
    $token = new Token();
    $token->import($tok);
    return $token->validate();
}