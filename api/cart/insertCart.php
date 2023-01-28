<?php

use Model\Cart\Cart;
use Model\Cart\CartAdditional;

$cart = new Cart;
$cartAdditional = new CartAdditional;

if (isset($_POST)) {

    if (isset($_POST['productQuantity'])) {

        $cartId = $cart->create($_SESSION['user']['user_id'], $_POST['productId'], $_POST['quantity']);
    } else {

        $cartId = $cart->create($_SESSION['user']['user_id'], $_POST['productId']);
    }

    if (isset($_POST['additionals'])) {
        $cartAdditional->create($cartId, $_POST['additionals']);
    }

    if ($cartId) {
        $response = [
            'response' => $cartId,
            'message' => 'Carrinho atualizado com Sucesso!'
        ];
    
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

}