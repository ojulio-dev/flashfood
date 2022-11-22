<?php

use Model\Cart\Cart;

$cart = new Cart;

echo json_encode($cartItems = $cart->read(), JSON_UNESCAPED_UNICODE);

?>