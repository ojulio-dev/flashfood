<?php

if (!isset($_GET['id'])) {
    header("Location: index.php?page=products");
}

use Model\Product;

use Model\ProductCategory;

$productCategory = new ProductCategory;

$product = new Product;

$readProducts = $product->readById($_GET['id']);

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
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Digite o Nome"  value="<?= $readProducts['name'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="category">Categoria</label>
                <select name="category" id="category" >
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?=$category['category_id'] == $readProducts['category_id'] ? 'selected' : ''?>><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="price">Preço</label>
                <input type="number" name="price" id="price" step="0.01" placeholder="R$ 100,99"  value="<?= $readProducts['price'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="special_price">Desconto</label>
                <input type="number" name="special_price" id="special_price" step="0.01" placeholder="R$ 50,99"  value="<?= $readProducts['special_price'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="description">Descrição</label>
                <input type="text" name="description" id="description" placeholder="Digite a Descrição"  value="<?= $readProducts['description'] ?>">
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" id="status" >
                    <option value="'1'" <?= 1 == $readProducts['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="'0'" <?= 0 == $readProducts['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="banner">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" id="banner" >
            </div>
        </div>

        <button type="button" class="button-submit success" onclick="updateProduct(<?= $readProducts['product_id'] ?>)">Atualizar</button>
        <button type="button" class="button-submit delete" onclick="deleteProduct(<?= $readProducts['product_id'] ?>)">Deletar</button>
    </form>
</section>