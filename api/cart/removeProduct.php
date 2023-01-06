<?php

use Model\Cart\Cart;

$cart = new Cart;

if ($cart->deleteByProductId($_SESSION['user']['user_id'], $_POST['productId'], $_SESSION['user']['user_id'])) {
    $response = [
        'response' => true,
        'message' => 'Produto removido do Carrinho!'
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}