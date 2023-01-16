<?php

use Model\User;

$user = new User();

if (isset($_POST['userId'])) {

    $delete = $user->delete($_POST['userId']);

    if ($delete) {

        echo json_encode($delete, JSON_UNESCAPED_UNICODE);
        exit();
    }
}