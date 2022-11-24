<?php

use Model\Role;

use Model\User;

$role = new Role;

$user = new User;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ?page=users");
}

$roles = $role->read();

$readUser = $user->readById($_GET['id']);

if (!$readUser) {
    
    header("Location: ?page=products");
    exit();
}

?>

<section class="main-update-user">
    <div class="dashboard-title-wrapper">
        <a href="?page=users">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Atualização</h1>
    </div>

    <form id="form-users-update" class="main-dashboard-form" method="POST">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="name-update-users">Nome</label>
                <input type="text" name="name" id="name-update-users" placeholder="Digite o Nome" value="<?= $readUser['name'] ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="email-update-users">E-mail</label>
                <input type="email" name="email" id="email-update-users" placeholder="Digite o E-mail" value="<?= $readUser['email'] ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="role-update-users">Nível de Acesso</label>
                <select name="role" id="role-update-users" required>
                    <?php foreach($roles as $roleItem): ?>
                        <option value="<?= $roleItem['role_id'] ?>" <?= $roleItem['role_id'] == $readUser['role_id'] ? 'selected    ' : '' ?>><?= $roleItem['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="main-input-wrapper">
                <label for="birthdate-update-users">Data de Nascimento</label>
                <input class="input-mask-date" type="date" max="<?= date('Y-m-d', strtotime('today')) ?>" name="birthdate" id="birthdate-update-users" placeholder="Digite a Data de Nascimento" value="<?= $readUser['birthdate'] ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="image-update-users">Imagem de Perfil</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="image" id="image-update-users">
            </div>
        </div>

        <button type="button" id="button-update-users" class="button-submit success" data-user-id="<?= $_GET['id'] ?>">Atualizar</button>
    </form>
</section>