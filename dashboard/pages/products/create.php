<?php

use Model\ProductCategory;
use Model\Ingredient;

$productCategory = new ProductCategory;
$ingredient = new Ingredient;

$categories = $productCategory->read();
$ingredients = $ingredient->read();

?>

<section class="main-create-product">
    <div class="dashboard-title-wrapper">
        <a href="?page=products">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Cadastro de Produtos</h1>
    </div>

    <form id="form-products-create" class="main-dashboard-form" method="POST" enctype="multipart/form-data">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="name-create-products">Nome</label>
                <input type="text" name="name" id="name-create-products" placeholder="Digite o Nome" required>
            </div>

            <div class="main-input-wrapper">
                <label for="category-create-products">Categoria</label>
                <select name="category_id" id="category-create-products" required>
                    <option value="" selected disabled>Selecione uma Categoria</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="main-input-wrapper">
                <label for="price-create-products">Preço</label>
                <input type="text" class="input-mask-money" name="price" id="price-create-products" placeholder="R$ 00,00" required>
            </div>

            <div class="main-input-wrapper">
                <label for="special_price_create_category">Desconto</label>
                <input type="text" class="input-mask-money" name="special_price" id="special_price_create_category" placeholder="R$ 00,00" required>
            </div>

            <div class="main-input-wrapper">
                <label for="description-create-products">Descrição</label>
                <input type="text" name="description" id="description-create-products" placeholder="Digite a Descrição" required>
            </div>

            <div class="main-input-wrapper -ingredients">
                <label for="ingredients-create-products">Adicionais</label>
                <select class="js-example-basic-multiple" name="ingredients[]" id="ingredients-create-products" multiple="multiple">
                    <option disabled>Selecione um Adicional para seu Produto (ou não)</option>
                    <?php foreach($ingredients as $ingredientItem): ?>
                        <option value="<?= $ingredientItem['ingredient_id'] ?>"><?= $ingredientItem['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="main-input-wrapper">
                <label for="banner-create-products">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" id="banner-create-products" required>
            </div>

            <div class="main-input-wrapper">
                <label for="status-create-products">Status</label>
                <select name="status" id="status-create-products" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-create-products" class="button-submit success create-products">Cadastrar</button>
    </form>
</section>