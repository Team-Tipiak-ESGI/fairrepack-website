<?php
require_once __DIR__ . '/../../utils/dao/coin.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);


$user = $_POST['user'];
$amount = $_POST['amount'];
echo json_encode(addCoin($amount, $user));
