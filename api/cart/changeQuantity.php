<?php

use Model\Cart\Cart;

$cart = new Cart;

$response = $cart->changeQuantity($_POST['quantity'], $_POST['productId']);

echo json_encode($response, JSON_UNESCAPED_UNICODE);