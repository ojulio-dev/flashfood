<?php

if (isset($_SESSION['flashfood']['user'])) {
    header("Location: ?page=home");
}

?>

<section class="main-scan-table">
    <h2><a href="?page=scanTable">FlashFood</a></h2>

    <div class="about-login">
        <h2>Bem-Vindo</h2>

        <p>Olá! Para ter acesso ao nosso sistema, é necessário criar uma conta (totalmente gratuita), por que você não cria uma?</p>

        <button><a href="?page=scanTable&action=create">Criar Conta</a></button>

        <small>Já possui uma conta? <a href="?page=scanTable&action=login">Faça Login</a></small>
    </div>
</section>