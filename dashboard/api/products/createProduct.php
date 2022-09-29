<?php

use Dashboard\Model\Product;

$product = new Product;

$isEmpty = false;

    foreach($_POST as $postItem) {
        if (empty($postItem)) {
            $isEmpty = true;
        }
    }

    if ($isEmpty || !isset($_FILES['banner'])) {
        
        $response = array(
            'response' => false,
            'message' => 'Digite as Informações corretamente!'
        );

        echo json_encode($response);
        exit();
    }

    $extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

    if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png') {

        $response = array(
            'response' => false,
            'message' => 'Formato de Arquivo inválido!'
        );

        echo json_encode($response);
        exit();
    }

    $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['category_id'] = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $data['price'] = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['special_price'] = filter_input(INPUT_POST, 'special_price', FILTER_SANITIZE_SPECIAL_CHARS);

    $data['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

    $create = $product->create($data);

    if ($create) {

        $response = array(
            'response' => true,
            'message' => 'Produto cadastrado com Sucesso!'
        );

        echo json_encode($response);
        exit();
    } else {

        $response = array(
            'response' => false,
            'message' => 'Eita, algo deu errado. Chame a equipe de manutenção o mais rápido possível!'
        );

        echo json_encode($response);
        exit();
    }

?>