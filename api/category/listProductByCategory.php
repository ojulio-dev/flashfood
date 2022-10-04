<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

$response = $productCategory->readByCategory($_POST['idCategory']);

if (!$response) {
    
    $response = false;
}

echo json_encode($response);