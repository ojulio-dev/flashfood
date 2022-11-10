<?php

use Model\User;

$user = new User;

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
            'message' => 'Digite as Informações corretamente!'
        );
    
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    $email = $_POST['email'];

    $password = sha1($_POST['password']);
    $confirmPassword = sha1($_POST['confirmPassword']);

    if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $response = [
            'response' => false,
            'message' => 'E-mail inválido! Verifique e tente novamente'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    if ($password != $confirmPassword) {
        $response = [
            'response' => false,
            'message' => 'As senhas não conferem! Verifique e tente novamente.'
        ];
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $create = $user->create($email, $password);

    if ($create) {

        $response = [
            'response' => true,
            'message' => 'Usuário cadastrado com Sucesso!'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

}