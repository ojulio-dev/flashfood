<?php

if (!isset($_GET['id'])) {
    header("Location: index.php?page=category");
}

$idCategory = $_GET['id'];

use Model\ProductCategory;

$productCategory = new ProductCategory;

$read = $productCategory->readById($_GET['id']);

if (!$read) {
    header("Location: index.php?page=category");
    exit();
}

$readProducts = $productCategory->readByCategory($_GET['id']);

?>

<section class="main-update-category">
    <div class="products-title-wrapper">
        <a href="?page=category">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-products-title">Atualização</h1>
    </div>

    <form class="main-products-form" method="POST">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="name">Categoria</label>
                <input type="text" name="name" id="update-name-category" placeholder="Digite a Categoria" value="<?= $read['name'] ?>" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" id="update-status-category" required>
                    <option value="'1'" <?= 1 == $read['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="'0'" <?= 0 == $read['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" class="button-submit success" id="button-update-category" data-category-id="<?= $read['category_id'] ?>">Atualizar</button>
        <button type="button" class="button-submit delete" onclick="deleteCategory(<?= $read['category_id'] ?>)">Deletar</button>
    </form>

    <section class="category-products-wrapper">
       
        <button onclick="listProductByCategory(<?= $idCategory ?>)" class="button-reload-category"><i class="fa-solid fa-rotate"></i> Ver Produtos</button>

        <div class="read-table-wrapper category">

            <table class="category-read-products">
                <tbody id="read-items-category"></tbody>
            </table>
        </div>
    </section>
</section>