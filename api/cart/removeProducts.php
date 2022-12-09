<?php

use Model\Cart\Cart;

$cart = new Cart();

$stmt = $cart->delete();

$response = [
  'response' => $stmt
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);