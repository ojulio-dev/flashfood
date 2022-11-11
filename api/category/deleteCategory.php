<?php

use Model\ProductCategory;

if (isset($_POST['categoryId'])) {

    $productCategory = new ProductCategory;

    $response = $productCategory->delete($_POST['categoryId']);

    if ($response) {
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
}