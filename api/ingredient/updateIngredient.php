<?php

use Model\Ingredient;

if 
(
    !key_exists('name', $_POST) || 
    !key_exists('price', $_POST) || 
    !key_exists('status', $_POST)
) {
    $response = array(
        'response' => false,
        'message' => 'Informações insuficientes para a Atualização!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$ingredient = new Ingredient;
  
$isEmpty = false;

foreach($_POST as $postItem) {
    if ($postItem != '0') {
        if (empty(trim($postItem))) {
            $isEmpty = true;
        }
    }
}

if ($isEmpty) {

    $response = array(
        'response' => false,
        'message' => 'Digite as informações corretamente!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$data['price'] = substr_replace(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);
$data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
$data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

$readBySlug = $ingredient->readBySlug($data['slug']);

if ($readBySlug) {

    $readById = $ingredient->readById($_POST['ingredientId']);

    if ($readById['slug'] != $readBySlug['slug']) {
        $response = array(
            'response' => false,
            'message' => 'Esse Ingrediente já está Cadastrado! Altere o Nome e tente Novamente.'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

}

$update = $ingredient->updateById($_POST['ingredientId'], $data);

if ($update === true) {
    
    $response = array(
        'response' => true,
        'message' => 'Ingrediente atualizado com Sucesso!'
    );
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}