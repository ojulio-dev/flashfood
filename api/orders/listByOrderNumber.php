<?php

use Model\Order\Order;

$order = new Order;

if (isset($_POST['orderNumber'])) {

    $orderData = $order->readByOrderNumber($_POST['orderNumber']);

    echo json_encode($orderData, JSON_UNESCAPED_UNICODE);
    
}
