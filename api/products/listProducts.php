<?php

use Model\Product;

$product = new product;

$response = $product->read();

echo json_encode($response);