<?php

use Model\Cart\CartAdditional;

$cartAdditional = new CartAdditional();

if (isset($_POST)) {
    $cartAdditionals = $cartAdditional->readByCartId($_POST['cartId']);

    if ($cartAdditionals) {
        
        echo json_encode($cartAdditionals, JSON_UNESCAPED_UNICODE);
        
    }
}