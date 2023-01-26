<?php

require_once(__DIR__ . '/../vendor/autoload.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

ob_start();

session_start();

require_once(__DIR__ . '/config/environment.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'orders';
$action = isset($_GET['action']) ? $_GET['action'] : 'main';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Title -->
    <link rel="shortcut icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
    <title>FlashFood</title>

    <!-- Meta TAGs -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= DIR_CSS ?>/style.css">

</head>
<body>
    <div id="container">
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
        const BASE_URL = "http://localhost/flashfood/kitchen";
    </script>

    <?php if (file_exists(__DIR__ . "/assets/js/$page.js")): ?>
    
        <script src="<?= DIR_JS ?>/<?= $page ?>.js"></script>
    
    <?php endif ?>
    
    <script src="<?= DIR_JS ?>/script.js"></script>
</body>
</html>