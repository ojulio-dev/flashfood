<?php

use Model\Order\Order;
use Model\Order\OrderItem;

$order = new Order();
$orderItem = new OrderItem();

$orders = $order->read();

$dateTime = new DateTime('now');

for ($i = 0; $i < count($orders); $i++) {

    $dataDifference = $dateTime->diff(new DateTime($orders[$i]['created_at']));

    $timeSpent = str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);    

    $timeTitle = ' segundos';

    if ($dataDifference->i) {
        $timeSpent = str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->s, 2, 0, STR_PAD_LEFT);
        $timeTitle = ' minutos';
    }

    if ($dataDifference->h) {
        $timeSpent = str_pad($dataDifference->h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($dataDifference->i, 2, 0, STR_PAD_LEFT);
        $timeTitle = ' horas';
    }

    if ($dataDifference->d) {
        $timeSpent = str_pad($dataDifference->d, 2, 0, STR_PAD_LEFT);
        $timeTitle = $dataDifference->d > 1 ? ' dias' : ' dia';
    }

    $orders[$i]['timeSpent'] = $timeSpent . $timeTitle;

    $orders[$i]['quantity'] = 0;

    $orders[$i]['quantity'] = $orderItem->readProductsQuantity($orders[$i]['order_id']);
}

?>

<section id="main-list-orders">
    <div class="dashboard-title-wrapper">
        <h1 class="main-dashboard-title">Pedidos</h1>
    </div>

    <?php if ($orders): ?>
        <ul class="main-orders-wrapper">
            <?php foreach($orders as $order): ?>
                <li>
                    <div class="orders-image-wrapper">
                        <img src="<?= DIR_IMG ?>/system/shopping-bag.png" alt="Imagem do Pedido">

                        <strong>#<?= $order['order_number'] ?></strong>
                        <span><?= $order['quantity'] ?></span>
                    </div>

                    <div class="orders-info-wrapper">
                        <div>
                            <small>Mesa <?= $order['table_number'] ?></small>  
                            <span><i class="fa-regular fa-clock"></i> <?= $order['timeSpent'] ?></span>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>

    <?php else: ?>
        <span>O sistema ainda não possui pedidos :/ Faça algum pedido clicando <a href="?page=orders&action=menu">aqui</a></span>
    <?php endif ?>

    <div class="main-modal" id="modal-order">
        <div class="modal-exit"></div>

        <div class="main-modal-wrapper -order">
            <div class="main-modal-title -order">
                <h2>Pedidos</h2>
                
                <i class="fa-solid fa-xmark cart-icon-exit icon-exit"></i>
            </div>

            <div class="info-container">
                <div class="table-wrapper">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="http://localhost/flashfood/assets/images/products/127.jpg" alt="Imagem do Produto">
                                </td>
                                <td>Sorvetes</td>
                                <td>Sorvete Maneiro</td>
                                <td>Qtd - 2</td>
                                <td><i class="fa-solid fa-angle-down"></i></td>

                                <td colspan="5">oioi</td>
                            </tr>
                        
                            <tr>
                                <td>
                                    <img src="http://localhost/flashfood/assets/images/products/45.jpg" alt="Imagem do Produto">
                                </td>
                                <td>Salgados</td>
                                <td>Coxinha</td>
                                <td>Qtd - 1</td>
                                <td><i class="fa-solid fa-angle-down"></i></td>
                            </tr>
                        
                            <tr>
                                <td>
                                    <img src="http://localhost/flashfood/assets/images/products/52.jpg" alt="Imagem do Produto">
                                </td>
                                <td>Salgados</td>
                                <td>Pizza 4 Quejos</td>
                                <td>Qtd - 2</td>
                                <td><i class="fa-solid fa-angle-down"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="buttons-wrapper">
                    <button>Pedido Finalizado</button>
                    <button>Cancelar Pedido</button>
                </div>
            </div>
        </div>
    </div>
</section>