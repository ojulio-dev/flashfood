<?php

use Model\Cart\Cart;

$cart = new Cart;

if ($cart->deleteByCartId($_SESSION['user']['user_id'], $_POST['cartId'])) {
    $response = [
        'response' => true,
        'message' => 'Produto removido do Carrinho!'
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}