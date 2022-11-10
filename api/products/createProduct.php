<?php

// Verifica se os campos necessários foram enviados.
if 
(
    !key_exists('name', $_POST) || 
    !key_exists('category_id', $_POST) || 
    !key_exists('price', $_POST) || 
    !key_exists('special_price', $_POST) || 
    !key_exists('description', $_POST) || 
    !key_exists('status', $_POST) ||
    !key_exists('banner', $_FILES)
) {
    $response = array(
        'response' => false,
        'message' => 'Informações insuficientes para o Cadastro!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

use Model\Product;

$product = new Product;

$isEmpty = false;

// Verifica se cada valor do formulário está vazio.
foreach($_POST as $postItem) {
    if ($postItem != '0') {
        if (empty(trim($postItem))) {
            $isEmpty = true;
        }
    }
}

if ($isEmpty || empty($_FILES['banner']['tmp_name'])) {
    
    $response = array(
        'response' => false,
        'message' => 'Digite as Informações corretamente!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png') {

    $response = array(
        'response' => false,
        'message' => 'Formato de Arquivo inválido!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$data['category_id'] = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

$data['price'] = substr_replace(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);
$data['special_price'] = substr_replace(filter_input(INPUT_POST, 'special_price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);

$data['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
$data['status'] = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
$data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

if ($product->readBySlug($data['slug'])) {
    $response = array(
        'response' => false,
        'message' => 'Produto já cadastrado! Altere o nome e tente novamente'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

if (strlen($data['price']) > 7 || strlen($data['special_price']) > 7) {
    $response = array(
        'response' => false,
        'message' => 'Valor do Produto inválido!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

$create = $product->create($data);

if ($create) {
    $response = array(
        'response' => true,
        'message' => 'Produto cadastrado com Sucesso!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
    
} else {

    $response = array(
        'response' => false,
        'message' => 'Eita, algo deu errado. Chame a equipe de manutenção o mais rápido possível!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

?>