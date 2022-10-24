<?php

if (!isset($_GET['slug'])) {
    header("Location: index.php?page=products");
}

use Model\Product;

use Model\ProductCategory;

$productCategory = new ProductCategory;

$product = new Product;

$readProducts = $product->readBySlug($_GET['slug']);

if (!$readProducts) {
    
    header("Location: index.php?page=products");
    exit();
}

$categories = $productCategory->read();

?>

<section class="main-update-products">
    <div class="products-title-wrapper">
        <a href="?page=products">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h1 class="main-products-title">Atualização de Produtos</h1>
    </div>

    <form id="form-products-update" class="main-products-form" method="POST" enctype="multipart/form-data">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="update-name-products">Nome</label>
                <input type="text" name="name" id="update-name-products" placeholder="Digite o Nome"  value="<?= $readProducts['name'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="update-category-products">Categoria</label>
                <select name="category" id="update-category-products">
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?=$category['category_id'] == $readProducts['category_id'] ? 'selected' : ''?>><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="update-price-products">Preço</label>
                <input type="text" class="input-mask-money" name="price" id="update-price-products" placeholder="R$ 00,00"  value="<?= $readProducts['price'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="update-special-price-products">Desconto</label>
                <input type="text" class="input-mask-money" name="special_price" id="update-special-price-products" placeholder="R$ 00,00"  value="<?= $readProducts['special_price'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="update-description-products">Descrição</label>
                <input type="text" name="description" id="update-description-products" placeholder="Digite a Descrição" value="<?= $readProducts['description'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="update-status-products">Status</label>
                <select name="status" id="update-status-products">
                    <option value="'1'" <?= 1 == $readProducts['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="'0'" <?= 0 == $readProducts['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="banner">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" required>
            </div>
        </div>

        <button type="button" id="button-update-products" class="button-submit success" data-product-id="<?= $readProducts['product_id'] ?>">Atualizar</button>
        
        <button type="button" id="button-delete-products" class="button-submit delete"  data-product-id="<?= $readProducts['product_id'] ?>">Deletar</button>
    </form>
</section>