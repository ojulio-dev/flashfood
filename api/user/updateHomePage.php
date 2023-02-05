<?php

use Model\User;

$user = new User();

if (isset($_POST)) {

    $userId = $_SESSION['flashfood']['user']['user_id'];

    $isEmpty = false;

    foreach($_POST as $postItem) {
        if ($postItem != '0' && !is_array($postItem)) {
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

    if (!empty($_FILES['image']['name'])) {
    
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
        if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png' && $extension != 'gif' && $extension != 'webp') {
    
            $response = array(
                'response' => false,
                'message' => 'Formato de arquivo inválido!'
            );
        
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }
    
        $data['image'] = $_FILES['image'];
        $data['image']['extension'] = $extension;
    }
    
    $data['name'] = filter_input(INPUT_POST, 'name');
    $data['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    
    $readByEmail = $user->readByEmail($data['email']);
    
    if ($readByEmail) {
        
        $readById = $user->readById($userId);
    
        if ($readByEmail['email'] != $readById['email']) {
    
            $response = array(
                'response' => false,
                'message' => 'Esse E-mail já está cadastrado! Insira outro e tente Novamente.'
            );
        
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        
        }
    }

    $update = $user->updateHomePage($data, $userId);

    if ($update) {

        $dataUser = $user->readForLogin($userId);
        
        if ($dataUser) {
            
            $_SESSION['flashfood']['user'] = $dataUser;

            $response = [
                'response' => true,
                'message' => 'Usuário logado com Sucesso!'
            ];
        
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();

        }
    }
}