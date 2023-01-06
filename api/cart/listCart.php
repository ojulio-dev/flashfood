<?php

use Model\Cart\Cart;

$cart = new Cart;

echo json_encode($cart->read($_SESSION['user']['user_id']), JSON_UNESCAPED_UNICODE);

?>