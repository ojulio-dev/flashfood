<?php

use Dashboard\Model\ProductCategory;

$categoryController = new ProductCategory;

$response = ['status' => false];

if (isset($_POST['categoryId'])) {

    $categoryId = $_POST['categoryId'];

    $category = $categoryController->readById($categoryId);

    $response['status'] = $categoryController->updateByField(!$category['status'], 'status', $categoryId);
}

echo json_encode($response);