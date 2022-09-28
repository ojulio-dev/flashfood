<?php

use Dashboard\Model\Product;

$productController = new Product;

$response = ['status' => false];

if (isset($_POST['productId'])) {

    $productId = $_POST['productId'];

    $product = $productController->readById($productId);

    $response['status'] = $productController->updateByField(!$product['status'], 'status', $productId);
}

echo json_encode($response);