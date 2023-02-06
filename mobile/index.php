<?php

require_once(__DIR__ . '/../vendor/autoload.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

ob_start();

session_start();

if (!isset($_SESSION['flashfood']['user'])) {
    header("Location: ../?page=login");
    exit();
}

require_once(__DIR__ . '/../config/environment.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'menu';
$action = isset($_GET['action']) ? $_GET['action'] : 'main';

use Model\Cart\Cart;

$cart = new Cart();

$readCart = $cart->read($_SESSION['flashfood']['user']['user_id']);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Title -->
    <link rel="shortcut icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
    <title>FlashFood - Mobile</title>

    <!-- Meta TAGs -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= DIR_MOBILE ?>/assets/css/reset.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="<?= DIR_MOBILE ?>/assets/css/cardapio/style.css">   
    <link rel="stylesheet" href="<?= DIR_MOBILE ?>/assets/css/carrinho/style.css">
    <link rel="stylesheet" href="<?= DIR_MOBILE ?>/assets/css/orders/style.css">

    <!-- Não importar abaixo dessas duas! Importe acima -->
    <link rel="stylesheet" href="<?= DIR_MOBILE ?>/assets/css/style.css">

    <?php if (count($readCart)): ?>
        <style>
            
            .floating-button-cart {
                display: flex;
            }

        </style>
    <?php endif; ?>

    <!-- Fonts -->
    <link rel="stylesheet" href="<?= DIR_MOBILE ?>/assets/css/fonts/style.css">

</head>
<body>
    <div id="container">
        <header class="header-responsivo">
            <div class="header-search-wrapper">
                <i class="fa-solid fa-magnifying-glass header-button-search"></i>
                <form action="" method="GET">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="q" placeholder="Pesquisar...">
                </form>
            </div>

            <a href="?page=menu"><img src="<?= DIR_MOBILE ?>/assets/images/header/logo-responsivo.png" alt="Logo do Sistema Responsivo"></a>

            <div class="header-menu-wrapper">
                <i id="header-burguer-icon" class="fa-solid fa-bars"></i>

                <div id="modal-header-menu" class="items-menu">

                    <div id="header-menu-close"></div>
                    
                    <div class="modal-wrapper">
                        <div class="title-wrapper">
                            <h2>Páginas</h2>
                            <i id="close-modal-header" class="fa-solid fa-xmark"></i>
                        </div>

                        <ul>
                            <li>
                                <a href="?page=menu">Cardápio</a>
                            </li>
                            <li>
                                <a href="?page=cart">Carrinho</a>
                            </li>
                            <li>
                                <a href="?page=orders">Pedidos</a>
                            </li>
                            <li>
                                <a href="../">Voltar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <?php

            if (file_exists(__DIR__ . "/pages/$page/$action.php")) {
                require_once(__DIR__ . "/pages/$page/$action.php");
            } else {
                header("Location: ?page=menu");
            }

            if (!isset($page)) {
                header("Location: ?page=menu");
            }

        ?>

        <a class="floating-button-cart" href="?page=cart">
            <i class="fa-solid fa-cart-shopping"></i>
            
            <span><?= count($readCart) <= 9 ? count($readCart) : '9+' ?></span>
        </a>
    </div>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Input Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js" integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Mask Money -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Vanilla -->
    <script>
        const DIR_PATH = "<?= DIR_MOBILE ?>";
        const SERVER_HOST = "<?= SERVER_HOST ?>";
    </script>

    <?php if (file_exists(__DIR__ . "/assets/js/$page.js")): ?>
    
        <script src="<?= DIR_MOBILE ?>/assets/js/<?= $page ?>.js"></script>
    
    <?php endif ?>
    
    <script src="<?= DIR_MOBILE ?>/assets/js/script.js"></script>
</body>
</html>