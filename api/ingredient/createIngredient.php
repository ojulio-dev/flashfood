<?php

use Model\Ingredient;

if (isset($_POST)) {

    $ingredient = new Ingredient;

    if (!key_exists('name', $_POST) || !key_exists('price', $_POST) || !key_exists('status', $_POST)) {
        $response = array(
            'response' => false,
            'message' => 'Informações insuficientes para o Cadastro!'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $isEmpty = false;

    foreach($_POST as $postItem) {
        if ($postItem != "0") {
            if (empty(trim($postItem))) {
                $isEmpty = true;
            }
        }
    }

    if ($isEmpty) {
        
        $response = array(
            'response' => false,
            'message' => 'Digite as Informações corretamente!'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['price'] = substr_replace(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

    if ($ingredient->readBySlug($data['slug'])) {
        $response = array(
            'response' => false,
            'message' => 'Esse Ingrediente já foi cadastrado! Altere o nome e tente novamente'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (!$data['name'] || !$data['price']) {

        $response = array(
            'response' => false,
            'message' => 'Digite as Informações corretamente!'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $create = $ingredient->create($data);

    if ($create === true) {

        $response = array(
            'response' => true,
            'message' => 'Ingrediente Cadastrado com sucesso!'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();

    }
}