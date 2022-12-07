<?php

use Model\Cart\Cart;

$cart = new Cart;

if (isset($_POST)) {

  $response = $cart->removeById($_POST['productId']);

  if ($response) {

    $response = [
        'response' => true
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

}