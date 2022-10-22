<?php

require_once(__DIR__ . '/../config/environment.php');
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../vendor/autoload.php');

if (isset($_GET['api'])) {
    if (!isset($_GET['action'])) {

        require_once($_GET['api'] . '.php');
    } else {
        
        require_once($_GET['api'] . '/' . $_GET['action'] . '.php');
    }  
}