<?php

if (!isset($_POST['categoryId'])) {
    // ...
}

use Model\ProductCategory;

$productCategory = new ProductCategory;

$response = $productCategory->delete($_POST['categoryId']);

if ($response) {
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}