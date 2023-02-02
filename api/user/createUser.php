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

    $name = filter_input(INPUT_POST, 'name');
    
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    $role = filter_input(INPUT_POST, 'role_id', FILTER_SANITIZE_NUMBER_INT);

    $birthdate = $_POST['birthdate'];

    $password = date('dmY', strtotime($birthdate));

    $password = sha1($password);

    if (!$name || !$email || !$role) {

        $response = [
            'response' => false,
            'message' => 'Informações inválidas! Verifique e tente Novamente'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $arrayBirthdate = explode('-', $_POST['birthdate']);

    if ($arrayBirthdate[0] > date('Y')) {
        $response = array(
            'response' => false,
            'message' => 'Data de Nascimento Inválida'
        );
    
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

    $create = $user->create($name, $email, $password, $role, $birthdate);

    if ($create) {

        $response = [
            'response' => true,
            'message' => 'Usuário cadastrado com Sucesso!'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }

}