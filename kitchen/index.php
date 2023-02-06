<?php

require_once(__DIR__ . '/../vendor/autoload.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

ob_start();

session_start();

require_once(__DIR__ . '/../config/environment.php');

if (!isset($_SESSION['flashfood']['user']) || $_SESSION['flashfood']['user']['role_id'] > 2) {
    header("Location: ../");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'orders';
$action = isset($_GET['action']) ? $_GET['action'] : 'main';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Title -->
    <link rel="shortcut icon" href="<?= SERVER_HOST ?>/assets/images/favicon/favicon.png" type="image/x-icon">
    <title>FlashFood - Cozinha</title>

    <!-- Meta TAGs -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="<?= DIR_KITCHEN ?>/assets/css/reset.css">

    <link rel="stylesheet" href="<?= DIR_KITCHEN ?>/assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

</head>
<body>
    <div id="container">
        <header id="header-kitchen">
            <a href="<?= SERVER_HOST ?>"><img src="<?= SERVER_HOST ?>/assets/images/system/flashfood_icon.png" alt=""></a>
        </header>

        <?php

            if (file_exists(__DIR__ . "/pages/$page/$action.php")) {
                require_once(__DIR__ . "/pages/$page/$action.php");
            } else {
                header("Location: ?page=orders");
            }

            if (!isset($page)) {
                header("Location: ?page=orders");
            }

        ?>
    </div>

    <script>
        const DIR_PATH = '<?= DIR_KITCHEN ?>'

        const SERVER_HOST = '<?= SERVER_HOST ?>'
    </script>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (file_exists(__DIR__ . "/assets/js/$page.js")): ?>
    
        <script src="<?= DIR_KITCHEN ?>/assets/js/<?= $page ?>.js"></script>
    
    <?php endif ?>
    
    <script src="<?= DIR_KITCHEN ?>/assets/js/script.js"></script>
</body>
</html>