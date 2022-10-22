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
                <input type="text" name="name" placeholder="Digite o Nome" required>
            </div>

            <div class="input-products-wrapper">
                <label for="category">Categoria</label>
                <select name="category_id" required>
                    <option value="" selected>Selecione uma Categoria</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="price">Preço</label>
                <input type="text" class="input-mask-money" name="price" placeholder="R$ 00,00" required>
            </div>

            <div class="input-products-wrapper">
                <label for="special_price">Desconto</label>
                <input type="text" class="input-mask-money" name="special_price" placeholder="R$ 00,00" required>
            </div>

            <div class="input-products-wrapper">
                <label for="description">Descrição</label>
                <input type="text" name="description" placeholder="Digite a Descrição" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>

            <div class="input-products-wrapper">
                <label for="banner">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" required>
            </div>
        </div>

        <button type="button" id="button-create-products" class="button-submit success create-products">Cadastrar</button>
    </form>
</section>