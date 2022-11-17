<?php

use Model\Ingredient;

if (isset($_POST['id'])) {

    $ingredient = new Ingredient;

    $delete = $ingredient->delete($_POST['id']);

    if ($delete === true) {

        $response = [
            'response' => true,
            'message' => 'Ingrediente deletado com Sucesso!'
        ];
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
}