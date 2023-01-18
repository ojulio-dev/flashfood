<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

if (isset($_GET['idCategory'])) {

    $response = $productCategory->readByCategoryAdmin($_GET['idCategory']);

    if (!$response) {
        
        $response = false;
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}