<?php

if (isset($_SESSION['flashfood']['user'])) {
    header("Location: ?page=home");
}

?>

<section class="main-scan-table">
    <h2><a href="?page=scanTable">FlashFood</a></h2>

    <form class="main-form-user" id="form-create-mobile">
        <h2>Cadastro</h2>

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
        </div>

        <button>Cadastrar</button>
    </form>
</section>