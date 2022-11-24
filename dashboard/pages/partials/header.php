<?php

use Model\Cart\Cart;

$cart = new Cart;

$cartItems = $cart->read();

?>

<div class="main-modal" id="modal-cart">
    <div class="main-modal-wrapper -cart">
        <div class="main-modal-title -cart">
            <h2>Carrinho</h2>
            
            <i class="fa-solid fa-xmark cart-icon-exit icon-exit"></i>
        </div>

        <ul class="main-item-modal -cart"></ul>

        <div class="button-order-wrapper">
            <button class="button-order cancel" type="button">Cancelar</button>
            <button class="button-order success" type="button">Finalizar Pedido</button>
        </div>
    </div>
</div>

<header class="main-dashboard-header">
    <img src="<?= DIR_SYSTEM ?>/assets/images/system/flashfood_icon.png" alt="">

    <div class="header-customer-wrapper">
        <div class="header-cart-wrapper">
            <i class="fa-solid fa-cart-shopping fa-lg icon-cart-modal"></i>
            <span class="icon-cart-modal" id="icon-count-cart-items"><?= count($cartItems) ?></span>
        </div>

        <i class="fa-solid fa-user fa-lg"></i>
    </div>
</header>