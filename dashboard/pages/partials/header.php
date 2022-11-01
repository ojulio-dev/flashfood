<?php

$mock = array(
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
            
            <i class="fa-solid fa-xmark icon-exit" id="icon-cart-exit"></i>
        </div>

        <ul class="main-item-modal -cart">
            <?php foreach($mock as $product): ?>
                <li>
                    <div class="cart-name-wrapper">
                        <i class="fa-solid fa-cart-shopping"></i>

                        <div class="cart-info-wrapper">
                            <h3><?= $product['name'] ?></h3>
                            <p><?= $product['price'] ?></p>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>

        </ul>

        <div class="button-order-wrapper">
            <button type="button">Finalizar Pedido</button>
        </div>
    </div>
</div>

<header class="main-dashboard-header">
    <img src="<?= DIR_IMG ?>/header/flashfood_icon.png" alt="">

    <div class="header-customer-wrapper">
        <i class="fa-solid fa-cart-shopping fa-lg" id="icon-cart-modal"></i>

        <i class="fa-solid fa-bell fa-lg"></i>

        <i class="fa-solid fa-user fa-lg"></i>
    </div>
</header>