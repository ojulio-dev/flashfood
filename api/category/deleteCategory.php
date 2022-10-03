<?php

if (!isset($_POST['categoryId'])) {
    // ...
}

use Model\ProductCategory;

$productCategory = new ProductCategory;

$response = $productCategory->delete($_POST['categoryId']);

echo json_encode($response);