<?php

use Model\Additional;

$additional = new Additional;

if (isset($_POST)) {
    
    $productSlug = $_POST['productSlug'];

    $ingredients = $additional->readIngredientsBySlug($productSlug);

    if (!$ingredients) {
        $response = ['response' => false];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $response = ['response' => true, 'ingredients' => $ingredients];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}