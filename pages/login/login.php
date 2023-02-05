<?php

if (isset($_SESSION['flashfood']['user'])) {
    header("Location: ?page=home");
}

?>

<section class="main-login">
    <?php require(__DIR__ . '/../partials/headerLogin.php') ?>

    <form class="main-form-user" id="form-login-mobile">
        <h2>
            <a href="?page=login"><i class="fa-solid fa-house"></i></a>
            <i class="fa-solid fa-arrow-right"></i> 
            Login
        </h2>

        <div class="inputs-wrapper">
            <div class="input-element">
                <label for="mobile-login-email">E-mail</label>
                <input id="mobile-login-email" name="email" type="email">
            </div>

            <div class="input-element">
                <label for="mobile-login-password">Senha</label>
                <input id="mobile-login-password" name="password" type="password">
            </div>
        </div>

        <button class="main-button-login -form">Entrar</button>
    </form>
</section>