<?php

use Model\Product;

if (isset($_POST['categoryId'])) {

    $product = new Product;

    $response = $product->readByCategoryId($_POST['categoryId']);

    echo json_encode($response);
}