<?php

if 
(
    !key_exists('name', $_POST) || 
    !key_exists('category_id', $_POST) || 
    !key_exists('price', $_POST) || 
    !key_exists('special_price', $_POST) || 
    !key_exists('description', $_POST) || 
    !key_exists('status', $_POST) ||
    !key_exists('productId', $_POST)
) {
    $response = array(
        'response' => false,
        'message' => 'Informações insuficientes para o Cadastro!'
    );

    echo json_encode($response);
    exit();
}

use Model\Product;

$product = new Product;
  
$isEmpty = false;

foreach($_POST as $postItem) {
    if ($postItem != '0') {
        if (empty(trim($postItem))) {
            $isEmpty = true;
        }
    }
}

if ($isEmpty) {

    header("Location: index.php?page=item&action=update?id=" . $_GET['id'] . "");
    exit();
}

if (!empty($_FILES['banner']['name'])) {
    $extension = pathinfo($_FILES['banner'], PATHINFO_EXTENSION);

    if ($extension != 'jpg' && $$extension != 'jpeg' && $$extension != 'png') {

        header("Location: index.php?page=item&action=update" . $_GET['id'] . "");
        exit();
    }
}

$data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$data['category_id'] = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
$data['price'] = substr_replace(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);
$data['special_price'] = substr_replace(filter_input(INPUT_POST, 'special_price', FILTER_SANITIZE_NUMBER_INT), '.', -2, 0);

$data['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
$data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
$data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

$update = $product->updateById($_POST['productId'], $data);

$response = array(
    'response' => true
);

echo json_encode($response);
exit();