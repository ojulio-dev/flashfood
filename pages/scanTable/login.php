<?php

if (isset($_SESSION['flashfood']['user'])) {
    header("Location: ?page=home");
}

?>

<section class="main-scan-table">
    <h2><a href="?page=scanTable">FlashFood</a></h2>

    <form class="main-form-user" id="form-login-mobile">
        <h2>Login</h2>

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

        <button>Entrar</button>
    </form>
</section>