<?php

use Model\Role;

$role = new Role;

$roles = $role->read();

?>

<section class="main-create-user">
    <div class="dashboard-title-wrapper">
        <a href="?page=users">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Cadastro de Usuários</h1>
    </div>

    <form id="form-users-create" class="main-dashboard-form" method="POST">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="name-create-users">Nome</label>
                <input type="text" name="name" id="name-create-users" placeholder="Digite o Nome" required>
            </div>

            <div class="main-input-wrapper">
                <label for="email-create-users">E-mail</label>
                <input type="email" name="email" id="email-create-users" placeholder="Digite o E-mail" required>
            </div>

            <div class="main-input-wrapper">
                <label for="role-create-users">Nível de Acesso</label>
                <select name="role_id" id="role-create-users" required>
                    <option value="" selected disabled>Selecione um Nivel</option>

                    <?php foreach($roles as $roleItem): ?>
                        <option value="<?= $roleItem['role_id'] ?>"><?= $roleItem['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="main-input-wrapper">
                <label for="birthdate-create-users">Data de Nascimento</label>
                <input class="input-mask-date" type="date" max="<?= date('Y-m-d', strtotime('today')) ?>" name="birthdate" id="birthdate-create-users" placeholder="Digite a Data de Nascimento" required>
            </div>
        </div>

        <button type="button" id="button-create-users" class="button-submit success">Cadastrar</button>
    </form>
</section>