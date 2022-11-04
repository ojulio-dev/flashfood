<?php

use Model\Admin;

if (isset($_POST)) {

    $admin = new Admin;
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

        $return = [
            'return' => false,
            'message' => 'Digite os Campos corretamente!'
        ]; 

        $json = json_encode($return);
        echo $json;

        exit();
    }

    if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {

        $return = [
            'return' => false,
            'message' => 'Digite um Email válido!'
        ]; 

        $json = json_encode($return);
        echo $json;
        
        exit();
    }
    
    if ($admin->checkUser($email, $password)) {

        session_start();
        
        $_SESSION['email'] = $email;

        $return = [
            'return' => true,
            'message' => 'Usuário logado com Sucesso!'
        ];
    } else {

        $return = [
            'return' => false,
            'message' => 'Email ou Senha inválidos! Verifique e tente novamente.'
        ];
    }

    $json = json_encode($return);
    echo $json;

    exit();
}
