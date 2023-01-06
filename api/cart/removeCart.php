<?php

use Model\Cart\Cart;

$cart = new Cart;

$delete = $cart->delete($_SESSION['user']['user_id']);

echo json_encode(['response' => $delete]);