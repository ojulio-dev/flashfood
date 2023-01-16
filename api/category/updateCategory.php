<?php

use Model\ProductCategory;

$productCategory = new ProductCategory();

if 
(
    !key_exists('name', $_POST) || 
    !key_exists('status', $_POST) ||
    !key_exists('categoryId', $_POST)
) {
    $response = array(
        'response' => false,
        'message' => 'Informações insuficientes para o Cadastro!'
    );

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}
  
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
$data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
$data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

$data['banner'] = $_FILES['banner'];

$readBySlug = $productCategory->readBySlug($data['slug']);

if ($readBySlug) {
    
    $readById = $productCategory->readById($_POST['categoryId']);

    if ($readById['slug'] != $readBySlug['slug']) {
        $response = array(
            'response' => false,
            'message' => 'Essa Categoria já está Cadastrada! Altere o Nome e tente Novamente.'
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
}

$update = $productCategory->updateById($_POST['categoryId'], $data);

$response = array(
    'response' => true,
    'message' => 'Categoria atualizada com Sucesso!'
);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();