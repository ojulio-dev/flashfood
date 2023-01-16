<?php

use Model\Order\Order;

$order = new Order;

if (isset($_POST['statusId'])) {

    $orderData = $order->readByStatusId($_POST['statusId']);

    echo json_encode($orderData, JSON_UNESCAPED_UNICODE);
    
}
