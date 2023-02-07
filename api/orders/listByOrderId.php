<?php

use Model\Order\Order;

$order = new Order;

if (isset($_POST['orderId'])) {

    $orderData = $order->readByOrderId($_POST['orderId']);

    echo json_encode($orderData, JSON_UNESCAPED_UNICODE);
    
}
