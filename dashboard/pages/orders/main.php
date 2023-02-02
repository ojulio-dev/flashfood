<?php

use Model\Order\Order;
use Model\Order\OrderItem;
use Model\Order\OrderStatus;

$order = new Order();
$orderItem = new OrderItem();
$orderStatus = new OrderStatus();

$orders = $order->read();

$readStatus = $orderStatus->read();

?>

<section id="main-list-orders">
    <div class="dashboard-title-wrapper">
        <h1 class="main-dashboard-title">Pedidos</h1>
    </div>

    <div class="orders-search-wrapper">
        <div class="search-form">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="orders-search" type="number" placeholder="Search...">
        </div>
        
        <form class="main-select-form">
            <select>
                <option value="" selected>Todos</option>

                <?php foreach($readStatus as $status): ?>
                    <option value="<?= $status['status_id'] ?>"><?= ucfirst($status['name']) ?></option>
                <?php endforeach ?>
            </select>
        </form>
    </div>

    <ul class="main-orders-wrapper" id="main-orders-wrapper">
        <?php if ($orders): ?>
            <?php foreach($orders as $order): ?>
                <style>
                    .main-orders-wrapper li#order-<?= $order['order_number'] ?> .orders-image-wrapper .number-status-wrapper .status-wrapper::after {
                        background-color: <?= $order['status_color'] ?>;
                    }

                    .main-orders-wrapper li#order-<?= $order['order_number'] ?> .orders-image-wrapper .number-status-wrapper .status-wrapper::before {
                        color: <?= $order['status_color'] ?>;
                    }
                        
                </style>
                
                <li id="order-<?= $order['order_number'] ?>">
                    <div class="orders-image-wrapper">
                        <img src="<?= DIR_IMG ?>/system/delivery-box.png" alt="Imagem do Pedido">

                        <strong>#<?= $order['order_number'] ?></strong>
                        <div class="number-status-wrapper">
                            <span class="quantity-products"><?= $order['quantity'] ?></span>

                            <span class="status-wrapper">
                                <small data-status-id="<?= $order['status_id'] ?>"><?= ucfirst($order['status_name']) ?></small>
                            </span>
                        </div>
                    </div>

                    <div class="orders-info-wrapper">
                        <div>
                            <small>Mesa <?= $order['table_number'] ?></small>  
                            <span><i class="fa-regular fa-clock"></i> <?= $order['timeSpent'] ?></span>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
            <?php else: ?>
                <li class="filter-notfound">O sistema ainda não possui pedidos. Faça algum pedido clicando <a href="?page=orders&action=menu">aqui</a></li>
            <?php endif ?>
        </ul>

    <div class="main-modal" id="modal-order">
        <div class="modal-exit"></div>

        <div class="main-modal-wrapper -order">
            <div class="main-modal-title -order">
                <h2>Pedidos</h2>
                
                <i class="fa-solid fa-xmark cart-icon-exit icon-exit"></i>
            </div>

            <div class="info-container">
                <div class="table-orders-wrapper">
                    <table>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="buttons-wrapper">
                    <button id="cancel-order-button">Cancelar Pedido</button>
                </div>
            </div>
        </div>
    </div>
</section>