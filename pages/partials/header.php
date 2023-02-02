<?php

if (isset($_SESSION['flashfood']['user']) && $_SESSION['flashfood']['user']['image']) {

    $destinyIcon = DIR_IMG . '/user/' . $_SESSION['flashfood']['user']['image'];

    $userIcon = !file_exists($destinyIcon) ? $destinyIcon : DIR_IMG . '/header/user_default.png';
    
} else {

    $userIcon = DIR_IMG . '/header/user_default.png';
}

?>

<header class="main-landingpage-header">
    <nav>
        <a href="?page=home">Página Inicial</a>
        <a href="">Sobre</a>
    </nav>

    <?php if (isset($_SESSION['flashfood']['user'])): ?>
        <i class="fa-solid fa-bars"></i>
    <?php else: ?>

        <button>Entrar <i class="fa-solid fa-user"></i></button>
    <?php endif; ?>
</header>