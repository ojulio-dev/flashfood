<?php

use Model\Product;

use Model\ProductCategory;

use Model\Additional;

use Model\Ingredient;

use function PHPSTORM_META\type;

$productCategory = new ProductCategory;

$product = new Product;

$additional = new Additional;

$ingredient = new Ingredient;

if (!isset($_GET['slug'])) {
    header("Location: ?page=products");
}

$readProducts = $product->readBySlug($_GET['slug']);

if (!$readProducts) {
    
    header("Location: ?page=products");
    exit();
}

$categories = $productCategory->read();

$additionals = $additional->readIngredientsBySlug($_GET['slug']);

$ingredients = $ingredient->read();

$extraIngredients = [];

if ($additionals) {

    foreach($ingredients as $ingredient) {
        $arraySearch = array_search($ingredient['ingredient_id'], array_column($additionals, 'ingredient_id'));
    
        if (is_bool($arraySearch)) {
            array_push($extraIngredients, $ingredient);
        }
    }

} else {

    $extraIngredients = $ingredients;
}

?>

<section class="main-update-products">
    <div class="dashboard-title-wrapper">
        <a href="?page=products">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h1 class="main-dashboard-title">Atualização de Produtos</h1>
    </div>

    <form id="form-products-update" class="main-dashboard-form" method="POST" enctype="multipart/form-data">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="update-name-products">Nome</label>
                <input type="text" name="name" id="update-name-products" placeholder="Digite o Nome"  value="<?= $readProducts['name'] ?>">
            </div>

            <div class="main-input-wrapper">
                <label for="update-category-products">Categoria</label>
                <select name="category" id="update-category-products">
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>" <?=$category['category_id'] == $readProducts['category_id'] ? 'selected' : ''?>><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="main-input-wrapper">
                <label for="update-price-products">Preço</label>
                <input type="text" class="input-mask-money" name="price" id="update-price-products" placeholder="R$ 00,00"  value="<?= $readProducts['price'] ?>">
            </div>

            <div class="main-input-wrapper">
                <label for="update-special-price-products">Desconto</label>
                <input type="text" class="input-mask-money" name="special_price" id="update-special-price-products" placeholder="R$ 00,00"  value="<?= $readProducts['special_price'] ?>">
            </div>

            <div class="main-input-wrapper">
                <label for="update-description-products">Descrição</label>
                <input type="text" name="description" id="update-description-products" placeholder="Digite a Descrição" value="<?= $readProducts['description'] ?>">
            </div>

            <div class="main-input-wrapper">
                <label for="update-status-products">Status</label>
                <select name="status" id="update-status-products">
                    <option value="'1'" <?= 1 == $readProducts['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="'0'" <?= 0 == $readProducts['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>

            <div class="main-input-wrapper">
                <label for="banner-update-products">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" id="banner-update-products" required>
            </div>

            <div class="main-input-wrapper -ingredients">
                <label for="ingredients-create-products">Adicionais</label>
                <select class="js-example-basic-multiple" name="ingredients[]" id="ingredients-create-products" multiple="multiple">
                    <option disabled>Selecione um Adicional para seu Produto (ou não)</option>
                    <?php foreach($additionals as $additional): ?>
                        <option selected value="<?= $additional['ingredient_id'] ?>"><?= $additional['name'] ?></option>
                    <?php endforeach ?>

                    <?php foreach($extraIngredients as $ingredientItem): ?>
                        <option value="<?= $ingredientItem['ingredient_id'] ?>"><?= $ingredientItem['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <button type="button" id="button-update-products" class="button-submit success" data-product-id="<?= $readProducts['product_id'] ?>">Atualizar</button>
        
        <button type="button" id="button-delete-products" class="button-submit delete"  data-product-id="<?= $readProducts['product_id'] ?>">Deletar</button>
    </form>
</section>