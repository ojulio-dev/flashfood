<?php

use Model\Cart\Cart;

$cart = new Cart;

if (isset($_POST)) {

    $response = $cart->changeQuantity($_SESSION['flashfood']['user']['user_id'], $_POST['quantity'], $_POST['cartId']);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}