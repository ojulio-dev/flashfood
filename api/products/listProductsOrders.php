<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

$categories = $productCategory->read();

$i = 0;

$products = array();

foreach($categories as $category) {

    $readProducts = $productCategory->readBySearch($category['category_id'], $_GET['search']);

    if (count($readProducts)) {
        $products[$i]['name'] = $category['name'];

        $products[$i]['products'] = $readProducts;

        $i++;
    }
};

$return = $products;

$json = json_encode($return, JSON_UNESCAPED_UNICODE);

echo $json;

exit();