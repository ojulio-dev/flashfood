<?php

use Model\Cart\Cart;
use Model\Table;

$cart = new Cart;
$table = new Table;

$cartItems = $cart->read($_SESSION['user']['user_id']);
$tables = $table->read();

?>

<div class="main-modal" id="modal-cart">
    <div class="modal-exit"></div>

    <div class="main-modal-wrapper -cart">
        <div class="main-modal-title -cart">
            <h2>Carrinho</h2>
            
            <i class="fa-solid fa-xmark cart-icon-exit icon-exit"></i>
        </div>

        <div class="info-container">
            <ul class="main-item-modal -cart"></ul>

            <div class="cart-tables-wrapper">
                <div class="modal-subtitle-wrapper">
                    <i class="fa-solid fa-arrow-left"></i>
                    
                    <h3>Selecione o número da Mesa</h3>
                </div>

                <ul>
                    <?php if (count($tables)): ?>
                        <?php foreach($tables as $tableItem): ?>
                            <li class="element-table" data-table-id="<?= $tableItem['table_id'] ?>"><?= $tableItem['table_number'] ?></li>
                        <?php endforeach ?>
                    <?php else: ?>
                        <li class="table-notfound" >O sistema ainda não possui nenhuma Mesa cadastrada. Para prosseguir com o Pedido, clique <a href="?page=tables&action=create">aqui.</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="button-order-wrapper">
                <button class="button-order cancel" type="button">Cancelar</button>
                <button class="button-order success continue" type="button">Continuar <i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>

<header class="main-dashboard-header">
    <img src="<?= SERVER_HOST ?>/assets/images/system/flashfood_icon.png" alt="">

    <div class="header-customer-wrapper">
        <div class="header-cart-wrapper">
            <i class="fa-solid fa-cart-shopping fa-lg icon-cart-modal"></i>
            <span class="icon-cart-modal" id="icon-count-cart-items"><?= count($cartItems) ?></span>
        </div>

        <i class="fa-solid fa-user fa-lg"></i>
    </div>
</header>