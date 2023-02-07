<?php

use Model\Order\Order;

$order = new Order();

$orders = $order->readByUserId($_SESSION['flashfood']['user']['user_id']);

?>

<section class="main-section-orders">
    <div class="main-title">
        <h2>Meus Pedidos</h2>
    </div>

    <div class="infos-wrapper">
        <?php if (count($orders)): ?>
            <ul class="orders-wrapper">
                <?php foreach($orders as $order): ?>

                    <li data-order-id="<?= $order['order_id'] ?>" data-order-number="<?= $order['order_number'] ?>" data-total-price="<?= $order['total_price'] ?>">
                        <span><?= $order['quantity'] ?></span>

                        <strong>#<?= ltrim($order['order_number'], 0) ?></strong>

                        <p style="background-color: <?= $order['status_color'] ?>;" class="order-status"><?= ucfirst($order['status_name']) ?></p>
                    </li>
                    
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="notfound">Nenhum pedido foi encontrado :/</p>
        <?php endif; ?>
    </div>

    <!-- Modal das Mesas -->
    <div id="orders-modal-items" class="main-modal-mobile">
        <div id="modal-orders-close" class="modal-mobile-close"></div>

        <div class="items-wrapper"></div>
    </div>
</section>