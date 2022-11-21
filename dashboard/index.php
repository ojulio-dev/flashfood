<?php

require_once(__DIR__ . '/../vendor/autoload.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

ob_start();

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] > 1) {
    header("Location: ../");
    exit();
}

require_once(__DIR__ . '/config/environment.php');
 
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'main';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Title -->
    <link rel="shortcut icon" href="<?= DIR_SYSTEM ?>/assets/images/favicon/favicon.png" type="image/x-icon">
    <title>Dashboard</title>

    <!-- Meta TAGs -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?= DIR_CSS ?>/reset.css">
    <link rel="stylesheet" href="<?= DIR_CSS ?>/fonts/fonts.css">

    <!-- Pages -->
    <link rel="stylesheet" href="<?= DIR_CSS ?>/products/read.css">
    <link rel="stylesheet" href="<?= DIR_CSS ?>/products/style.css">

    <link rel="stylesheet" href="<?= DIR_CSS ?>/category/style.css">
    <link rel="stylesheet" href="<?= DIR_CSS ?>/category/update.css">

    <link rel="stylesheet" href="<?= DIR_CSS ?>/orders/style.css">

    <!-- Carousel -->
    <link rel="stylesheet" href="<?= DIR_CSS ?>/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= DIR_CSS ?>/owlcarousel/owl.theme.default.min.css">

    <link rel="stylesheet" href="<?= DIR_CSS ?>/style.css">
    <link rel="stylesheet" href="<?= DIR_CSS ?>/responsive.css">
</head>
<body>
    <div id="container">
        <?php require_once (__DIR__. '/pages/partials/header.php') ?>
        
        <section class="main-section">
            <?php require_once (__DIR__. '/pages/partials/aside.php') ?>
            
            <main class="main-content">
                <?php if (isset($_SESSION['flash'])): ?>
                    <div class="flash-message <?= $_SESSION['flash']['color'] ?>">
                        <span><?= $_SESSION['flash']['message'] ?></span>
                    </div>
                <?php unset($_SESSION['flash']); endif; ?>

                <?php  

                if (file_exists(__DIR__ . "/pages/$page/$action.php")) {
                    require_once(__DIR__ . "/pages/$page/$action.php");
                } else {
                    header("Location: index.php?page=products");
                }

                if (!isset($page)) {
                    header("Location: index.php?page=products");
                }

                ?>
            </main>
        </section>

    </div>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Input Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js" integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Mask Money -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- OwlCarousel -->
    <script src="<?= DIR_JS ?>/owlcarousel/owl.carousel.min.js"></script>

    <!-- Vanilla -->
    <script>
        const BASE_URL = "http://localhost/flashfood/dashboard/";
        
        const API_URL = "http://localhost/flashfood/"; 
    </script>


    <?php if (file_exists(__DIR__ . "/assets/js/$page.js")): ?>
    
        <script src="<?= DIR_JS ?>/<?= $page ?>.js"></script>
    
    <?php endif ?>
    
    <script src="<?= DIR_JS ?>/script.js"></script>
</body>
</html>