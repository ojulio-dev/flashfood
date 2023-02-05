<?php

use Model\Order\Order;

$order = new Order();

$orders = $order->readKitchen();


?>

<section>
    <div id="title">
        <h2>Pedidos</h2>
    </div>

    <div id="main-orders">
        <?php foreach($orders as $data): ?>
            <div class="elements-order" data-order-id="<?= $data['order_id'] ?>" data-status-id="<?= $data['status_id'] ?>">
                <div class="order-info">
                    <div class="position-number-wrapper">
                        <span><?= $data['table_number'] ?></span>

                        <h4>#<?= $data['order_number'] ?></h4>
                    </div>
                    <div class="user-time-wrapper">
                        <p><i class="fa-solid fa-user"></i> <?= $data['user_name'] ?></p>
                        <span><i class="fa-regular fa-clock"></i> <?= $data['timeSpent'] ?></span>
                    </div>
                </div>

                <div class="products-wrapper">

                    <ul>
                        <?php foreach($data['order_items'] as $orderItem): ?>

                            <li class="order-wrapper">
                                <h5><span><?= $orderItem['quantity'] ?></span> <?= $orderItem['product_name'] ?></h5>

                                <?php if (count($orderItem['additionals'])): ?>
                                    <ul class="additionals-wrapper">
                                        <?php foreach($orderItem['additionals'] as $additional): ?>
                                            <li>
                                                <i class="fa-solid fa-plus symbol-additional"></i>
                                                <small><?= $additional['additional_name'] ?> (<?= $additional['quantity'] ?>)</small>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                        
                                <?php endif; ?>

                                <?php if($orderItem['note']) { ?>

                                    <div class="obs-wrapper">
                                        <span>* <?php echo $orderItem['note']?></span>
                                    </div>

                                <?php } ?>
                            </li>

                        <?php endforeach; ?>
                    </ul>

                </div>

                <?php if ($data['status_id'] == 1): ?>

                    <button class="button-action-order -pendente">Começar</button>

                <?php else: ?>

                    <button class="button-action-order -processando">Finalizar</button>

                <?php endif; ?>
            </div>
        <?php endforeach ?>
    </div>
</section>