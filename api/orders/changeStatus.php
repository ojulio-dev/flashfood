<?php

use Model\Order\Order;

$order = new Order();

if (isset($_POST)) {

    $changeStatus = $order->changeStatus($_POST['orderId'], $_POST['statusId']);

    echo json_encode($changeStatus);

}