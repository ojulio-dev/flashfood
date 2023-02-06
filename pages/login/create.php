<?php

if (isset($_SESSION['flashfood']['user'])) {
    header("Location: ?page=home");
}

?>

<section class="main-login">
    <?php require(__DIR__ . '/../partials/headerLogin.php') ?>

    <form class="main-form-user" id="form-create-mobile">
        <h2>
            <a href="?page=login"><i class="fa-solid fa-house"></i></a>
            <i class="fa-solid fa-arrow-right"></i> 
            Cadastro
        </h2>

        <div class="inputs-wrapper">
            <div class="input-element">
                <label for="mobile-create-name">Nome</label>
                <input id="mobile-create-name" name="name" type="text">
            </div>

            <div class="input-element">
                <label for="mobile-create-email">E-Mail</label>
                <input id="mobile-create-email" name="email" type="text">
            </div>

            <div class="input-element">
                <label for="mobile-create-date">Data de Nascimento</label>
                <input id="mobile-create-date" name="birthdate" type="text" class="date">
            </div>

            <p>A sua Data de Nascimento será sua senha inicial.</p>
        </div>

        <button class="main-button-login -form">Cadastrar</button>
    </form>
</section>