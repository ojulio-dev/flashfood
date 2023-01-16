<?php

use Model\Order\Order;
use Model\Order\OrderItem;

$order = new Order;

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

echo json_encode($orders, JSON_UNESCAPED_UNICODE);