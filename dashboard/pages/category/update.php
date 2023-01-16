<?php

if (!isset($_GET['slug'])) {
    header("Location: ?page=category");
}

use Model\ProductCategory;

$productCategory = new ProductCategory;

$read = $productCategory->readBySlug($_GET['slug']);

if (!$read) {
    header("Location: ?page=category");
    exit();
}

$readProducts = $productCategory->readByCategory($read['category_id']);

?>

<section class="main-update-category">
    <div class="dashboard-title-wrapper">
        <a href="?page=category">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Atualização</h1>
    </div>

    <form  id="form-category-update" class="main-dashboard-form" method="POST">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="update-name-category">Categoria</label>
                <input type="text" name="name" id="update-name-category" placeholder="Digite a Categoria" value="<?= $read['name'] ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="banner-update-category">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" id="banner-update-category" required>
            </div>

            <div class="main-input-wrapper">
                <label for="update-status-category">Status</label>
                <select name="status" id="update-status-category" required>
                    <option value="'1'" <?= 1 == $read['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="'0'" <?= 0 == $read['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-update-category" class="button-submit success" data-category-id="<?= $read['category_id'] ?>">Atualizar</button>

        <button type="button" id="button-delete-category" class="button-submit delete" data-category-id="<?= $read['category_id'] ?>">Deletar</button>
    </form>

    <section class="category-products-wrapper">
       
        <button id="button-read-products-category" class="button-reload" data-product-id="<?= $read['category_id'] ?>"><i class="fa-solid fa-rotate"></i> Ver Produtos</button>

        <div class="read-table-wrapper category">

            <table class="category-read-products">
                <tbody id="read-items-category"></tbody>
            </table>
        </div>
    </section>
</section>