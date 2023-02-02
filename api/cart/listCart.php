<?php

use Model\Cart\Cart;

$cart = new Cart;

$response['readCart'] = $cart->read($_SESSION['flashfood']['user']['user_id']);

$response['totalPrice'] = $cart->readTotalPrice($_SESSION['flashfood']['user']['user_id']);

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>