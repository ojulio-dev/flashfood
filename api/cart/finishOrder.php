<?php

use Model\Cart\Cart;
use Model\Order\Order;
use Model\Cart\CartAdditional;

$cart = new Cart();
$order = new Order();
$cartAdditional = new CartAdditional();

if (isset($_POST['tableId'])) {

    $orderItems = $cart->read($_SESSION['flashfood']['user']['user_id']);

    $newOrder = $order->create($orderItems, $_POST['tableId'], $_SESSION['flashfood']['user']['user_id']);

    $changeStatus = $cart->changeStatus($_SESSION['flashfood']['user']['user_id']);

    if ($orderItems && $newOrder && $changeStatus) {
        echo json_encode(['response' => true, 'message' => 'Pedido finalizado com Sucesso!', 'orderNumber' => $newOrder, 'tableNumber' => $_POST['tableId']], JSON_UNESCAPED_UNICODE);
    }

}