<?php

use Model\Cart\Cart;
use Model\Cart\CartAdditional;

$cart = new Cart;
$cartAdditional = new CartAdditional;

if (isset($_POST)) {

    if ($cart->readByProductId($_POST['productId'])) {
        $response = [
            'message' => 'Esse Produto já foi Adicionado ao Carrinho...',
            'response' => false
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $cart->create($_SESSION['user']['user_id'], $_POST['productId']);

    $response = [
        'response' => true,
        'message' => 'Carrinho atualizado com Sucesso!'
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();

}