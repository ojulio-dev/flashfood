<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

$categories = $productCategory->read();

?>

<section class="main-create-product">
    <div class="products-title-wrapper">
        <a href="?page=products">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-products-title">Cadastro de Produtos</h1>
    </div>

    <form id="form-products-create" class="main-products-form" method="POST" enctype="multipart/form-data">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Digite o Nome" required>
            </div>

            <div class="input-products-wrapper">
                <label for="category">Categoria</label>
                <select name="category_id" id="id_category" required>
                    <option value="" selected>Selecione uma Categoria</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="price">Preço</label>
                <input type="number" name="price" id="price" step="0.01" placeholder="R$ 100,99" required>
            </div>

            <div class="input-products-wrapper">
                <label for="special_price">Desconto</label>
                <input type="number" name="special_price" id="special_price" step="0.01" placeholder="R$ 50,99" required>
            </div>

            <div class="input-products-wrapper">
                <label for="description">Descrição</label>
                <input type="text" name="description" id="description" placeholder="Digite a Descrição" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="banner">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" id="banner" required>
            </div>
        </div>

        <button type="button" class="button-submit success create-products" onclick="addProduct()">Cadastrar</button>
    </form>
</section>