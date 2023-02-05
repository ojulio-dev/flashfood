<?php

use Model\User;

if (isset($_POST)) {

    $user = new User;
    
    $email = $_POST['email'];
    $password =  sha1($_POST['password']);

    if (empty($email) || empty($password)) {

        $response = [
            'response' => false,
            'message' => 'Digite os Campos corretamente!'
        ]; 

        $json = json_encode($response, JSON_UNESCAPED_UNICODE);
        echo $json;

        exit();
    }

    if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {

        $response = [
            'response' => false,
            'message' => 'Digite um E-mail válido!'
        ]; 

        $json = json_encode($response, JSON_UNESCAPED_UNICODE);
        echo $json;
        
        exit();
    }

    $dataUser = $user->loginUser($email, $password);
    
    if ($dataUser) {
        
        $_SESSION['flashfood']['user'] = $dataUser;

        $response = [
            'response' => true,
            'message' => 'Usuário logado com Sucesso!'
        ];

    } else {

        $response = [
            'response' => false,
            'message' => 'E-mail ou Senha inválidos! Verifique e tente novamente.'
        ];
    }

    $json = json_encode($response, JSON_UNESCAPED_UNICODE);
    echo $json;

    exit();
}
