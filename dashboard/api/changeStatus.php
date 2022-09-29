<?php

use Dashboard\Model\ProductCategory;
use Dashboard\Model\Product;

$categoryController = new ProductCategory;
$productController = new Product;

$statusData = $_POST['statusData'];

$response = ['status' => false];

if (isset($statusData['statusId'])) {

    if ($statusData['statusAction'] == 'product') {

        $productId = $statusData['statusId'];

        $product = $productController->readById($productId);

        $response['status'] = $productController->updateByField(!$product['status'], 'status', $productId);

    } elseif ($statusData['statusAction'] == 'category') {

        $categoryId = $statusData['statusId'];

        $category = $categoryController->readById($categoryId);

        $response['status'] = $categoryController->updateByField(!$category['status'], 'status', $categoryId);
    }
}

echo json_encode($response);