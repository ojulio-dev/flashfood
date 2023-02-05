<?php

if (isset($_SESSION['flashfood']['user'])) {
    header("Location: ?page=home");
}

?>

<section class="main-login">
    <header>
        <a href="?page=home">FlashFood</a>
    </header>

    <div class="about-login">
        <h2>Bem-Vindo!</h2>

        <p>Para ter acesso ao nosso sistema, é necessário criar uma conta (totalmente gratuita), por que você não cria uma?</p>

        <button class="main-button-login"><a href="?page=login&action=create">Criar Conta</a></button>

        <small>Já possui uma conta? <a href="?page=login&action=login">Faça Login</a></small>
    </div>
</section>