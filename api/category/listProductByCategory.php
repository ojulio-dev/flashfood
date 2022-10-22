<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

$response = $productCategory->readByCategory($_GET['idCategory']);

if (!$response) {
    
    $response = false;
}

echo json_encode($response);