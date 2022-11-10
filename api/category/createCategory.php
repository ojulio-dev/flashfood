<?php

if (!key_exists('name', $_POST) || !key_exists('status', $_POST)) {
    $response = array(
        'response' => false,
        'message' => 'Informações insuficientes para o Cadastro!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

use Model\ProductCategory;

$productCategory = new ProductCategory;

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
        'message' => 'Digite as Informações corretamente!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$data['slug'] = strtolower(str_replace(' ', '-', $data['name']));
$data['status'] = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

if ($productCategory->readBySlug($data['slug'])) {
    $response = array(
        'response' => false,
        'message' => 'Esta categoria já foi cadastrada! Altere o nome e tente novamente'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

if (!$data['name'] || !$data['status']) {
    $response = array(
        'response' => false,
        'message' => 'Digite as Informações corretamente!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$create = $productCategory->create($data);

if ($create) {

    $response = array(
        'response' => true,
        'message' => 'Categoria cadastrada com sucesso!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();

} else {

    $response = array(
            'response' => false,
            'message' => 'Algo de errado aconteceu. Informe a equipe técnica o mais rápido possível!'
        );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}