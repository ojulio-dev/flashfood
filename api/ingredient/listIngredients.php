<?php

use Model\Ingredient;

$ingredient = new Ingredient;

$response = $ingredient->read();

if ($response) {

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}