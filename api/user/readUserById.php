<?php

use Model\User;

$user = new User();

echo json_encode($user->readForLogin($_SESSION['flashfood']['user']['user_id']));