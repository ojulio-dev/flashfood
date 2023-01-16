<?php

use Model\Table;

$table = new Table;

if (isset($_POST)) {

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

    $data['tableNumber'] = filter_input(INPUT_POST, 'table_number', FILTER_SANITIZE_NUMBER_INT);
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

    if (!!!$data['tableNumber'] || $data['tableNumber'] < 1 ||($data['status'] != 1 && $data['status'] != 0)) {

        $response = [
            'response' => false,
            'message' => 'Informações inválidas! Verifique e tente Novamente'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if ($table->readByTableNumber($_POST['table_number'])) {
       
        $response = [
            'response' => false,
            'message' => 'A mesa digitada já existe! Coloque outro número.'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $update = $table->updateByTableId($data, $_POST['tableId']);

    if ($update) {
        
        $response = [
            'response' => true,
            'message' => 'Mesa atualizado com Sucesso!'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
}