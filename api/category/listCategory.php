<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

$response = $productCategory->readwithCount();

echo json_encode($response);