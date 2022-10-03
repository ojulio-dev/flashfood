<?php

if (!isset($_POST['productId'])) {
    // ...
}

use Model\Product;

$product = new Product;

$response = $product->delete($_POST['productId']);

echo json_encode($response);