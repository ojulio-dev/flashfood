<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

ob_start();

session_start();

require_once('config/environment.php');
 
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'main';

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <!-- Title -->
        <link rel="shortcut icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
        <title>Dashboard</title>

        <!-- Meta TAGs -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="<?= DIR_CSS ?>/config.css">
        <link rel="stylesheet" href="<?= DIR_CSS ?>/fonts/fonts.css">

        <!-- Pages -->
        <link rel="stylesheet" href="<?= DIR_CSS ?>/home/style.css">

        <!-- Produtos -->
        <link rel="stylesheet" href="<?= DIR_CSS ?>/home/products/create.css">

        <link rel="stylesheet" href="<?= DIR_CSS ?>/style.css">
    </head>
    <body>
        <div id="container">
            <?php require_once (__DIR__. '/pages/partials/header.php') ?>
            
            <section class="main-section">
                <?php require_once (__DIR__. '/pages/partials/aside.php') ?>
                
                <main class="main-content">
                    <?php  

                    if (file_exists(__DIR__ . "/pages/$page/$action.php")) {
                        require_once(__DIR__ . "/pages/$page/$action.php");
                    } else {
                        header("Location: index.php?page=home");
                    }

                    if (!isset($page)) {
                        header("Location: index.php?page=home");
                    }

                    ?>
                </main>
            </section>

        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= DIR_JS ?>/script.js"></script>

    </body>
</html>