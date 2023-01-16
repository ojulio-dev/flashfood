<?php

use Model\Product;
use Model\Additional;

$product = new Product;

$additional = new Additional;

if (isset($_POST)) {

    $isEmpty = false;

    foreach($_POST as $postItem) {
        if (floatval($postItem != '0') && !is_array($postItem)) {
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

    if (!empty($_FILES['banner']['name'])) {
        $extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

        if ($extension != 'jpg' && $$extension != 'jpeg' && $$extension != 'png') {

            $response = array(
                'response' => false,
                'message' => 'Formato de arquivo inválido!'
            );
        
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }

    $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['category_id'] = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $data['price'] = substr_replace(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);
    $data['special_price'] = substr_replace(filter_input(INPUT_POST, 'special_price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);

    $data['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));
    $data['banner'] = $_FILES['banner'];

    if (floatval($data['special_price'] <= 0 )) {
        
        $data['special_price'] = null;

    }

    $readBySlug = $product->readBySlug($data['slug']);

    if ($readBySlug) {

        $readByProductId = $product->readByProductId($_POST['productId']);

        if ($readBySlug['slug'] != $readByProductId['slug']) {
            
            $response = array(
                'response' => false,
                'message' => 'Esse Produto já está cadastrado! Altere o nome e tente novamente.'
            );
        
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }

    }

    $update = $product->updateById($_POST['productId'], $data);

    $additional->delete($_POST['productId']);

    if (isset($_POST['ingredients'])) {

        $additional->create($_POST['ingredients'], $_POST['productId']);
    }

    $response = array(
        'response' => true,
        'message' => 'Produto atualizado com Sucesso!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();

}