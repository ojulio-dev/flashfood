<?php

use Model\Order\Order;

$order = new Order;

$orderData = $order->readByUserId($_SESSION['flashfood']['user']['user_id']);

echo json_encode($orderData, JSON_UNESCAPED_UNICODE);