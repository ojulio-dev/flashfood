<?php

use Classes\Functions;

$functions = new Functions;

if (isset($_POST)) {

    $statusData = $_POST['statusData'];
    
    $itemId = $statusData['statusId'];
    
    $item = $functions->readByTableId($itemId, $statusData['table']);

    if ($item) {

        $functions->changeStatus(!$item['status'], $itemId, $statusData['table']);

        $response = [
            'response' => true,
            'message' => 'Status atualizado com Sucesso!'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

}