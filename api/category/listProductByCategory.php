<?php

var_dump($_GET);

exit();

use Model\ProductCategory;

$productCategory = new ProductCategory;

$response = $productCategory->readByCategory($_POST['idCategory']);

echo json_encode($response);