<?php

use Model\Cart\Cart;

$cart = new Cart;

$quantity = $cart->readByProductId($_POST['productId'])['quantity'];

$response = $cart->updateQuantity($quantity, $_POST['productId']);

echo json_encode($response, JSON_UNESCAPED_UNICODE);