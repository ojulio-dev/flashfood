<?php

use Model\Order\Order;
use Model\Order\OrderItem;

$order = new Order;

$orderItem = new OrderItem();

$orders = $order->readKitchen();

echo json_encode($orders, JSON_UNESCAPED_UNICODE);