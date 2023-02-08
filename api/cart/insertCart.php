<?php

use Model\Cart\Cart;
use Model\Cart\CartAdditional;

$cart = new Cart;
$cartAdditional = new CartAdditional;

if (isset($_POST)) {

    $cartId = false;

    if (isset($_POST['productQuantity'])) {

        if ($_POST['note']){

            $cartId = $cart->create($_SESSION['flashfood']['user']['user_id'], $_POST['productId'], $_POST['productQuantity'], $_POST['note']);
    
        } else {
    
            $cartId = $cart->create($_SESSION['flashfood']['user']['user_id'], $_POST['productId'], $_POST['productQuantity']);
            
        }

    } else {

        if (isset($_POST['note'])) {

            $cartId = $cart->create($_SESSION['flashfood']['user']['user_id'], $_POST['productId'], 1, $_POST['note']);
    
        } else {
    
            $cartId = $cart->create($_SESSION['flashfood']['user']['user_id'], $_POST['productId']); 
            
        }
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