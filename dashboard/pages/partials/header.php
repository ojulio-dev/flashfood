<?php

$mock = array(
    [
        'name' => 'Sorvete Qualquer qualquer coisa sei la amarelo',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Açaí ao Molho',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Sorvete Qualquer',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Açaí ao Molho',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ]
);

?>

<div class="main-modal" id="modal-cart">
    <div class="main-modal-wrapper -cart">
        <div class="main-modal-title -cart">
            <h2>Carrinho</h2>
            
            <i class="fa-solid fa-xmark cart-icon-exit icon-exit"></i>
        </div>

        <ul class="main-item-modal -cart">
            <?php foreach($mock as $product): ?>
                <li>
                    <div class="cart-name-wrapper">
                        <i class="fa-solid fa-cart-shopping icon-cart"></i>

                        <div class="cart-info-wrapper">
                            <h3><?=
                                strlen($product['name']) > 15
                                ? substr($product['name'], 0, 15) . '...' 
                                : $product['name']
                            ?></h3>
                            <p>R$ <?= number_format($product['price'], 2, ',', '.') ?></p>
                        </div>
                    </div>
                    <div class="cart-edit-amount">
                        <button type="button"><i class="fa-solid fa-minus"></i></button>
                        <input type="text" disabled value="2">
                        <button type="button"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>

        <div class="button-order-wrapper">
            <button class="button-order cancel" type="button">Cancelar</button>
            <button class="button-order success" type="button">Finalizar Pedido</button>
        </div>
    </div>
</div>

<header class="main-dashboard-header">
    <img src="<?= DIR_SYSTEM ?>/assets/images/system/flashfood_icon.png" alt="">

    <div class="header-customer-wrapper">
        <i class="fa-solid fa-cart-shopping fa-lg" id="icon-cart-modal"></i>

        <i class="fa-solid fa-user fa-lg"></i>
    </div>
</header>