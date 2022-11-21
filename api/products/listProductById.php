<?php

use Model\Product;

$product = new Product;

if (isset($_POST['productId'])) {

    $response = $product->readById($_POST['productId']);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}