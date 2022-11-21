<?php

use Model\User;

$user = new User;

$users = $user->read();

?>

<section class="main-read-users">
    <div class="dashboard-title-wrapper">
        <h1 class="main-dashboard-title">Usuários</h1>
    </div>

    <div class="products-search-wrapper">
        <div class="search-form">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="user-search" type="search" placeholder="Search...">
        </div>
    
    </div>

    <div class="ingredient-table-scroll-wrapper">
        <table class="main-read-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Nível</th>
                    <th>Data de Nascimento</th>
                    <th>Status</th>
                    <th class="read-table-action">Action</th>
                </tr>
            </thead>
            <tbody id="read-table-users-items">
                <?php if ($users): foreach($users as $userItem): ?>
                    <tr>
                        <td><?= $userItem['user_id'] ?></td>
                        <td><?= $userItem['name'] ?></td>
                        <td><?= $userItem['email'] ?></td>
                        <td><?= ucfirst($userItem['role']) ?></td>
                        <td><?= date('d/m/Y', strtotime($userItem['birthdate'])) ?></td>
                        <td class="read-table-status">
                            <form>
                                <input name="status-read-users" id="status-read-users" onclick="changeStatus(<?= $userItem['user_id'] ?>, 'user')" type="checkbox" <?= $userItem['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status"></label>
                            </form>
                        </td>
                        <td class="read-table-action">
                            <div class="read-table-icons-wrapper">
                                <a href="index.php?page=users&action=update&id=<?= $userItem['user_id'] ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php  endforeach; else: ?>
                    <tr>
                        <td>Nenhum Ingrediente cadastrado, cadastre clicando <a class="link-no-results" href="index.php?page=ingredient&action=create">aqui</a></td> 
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>