<?php

if (!isset($_GET['id'])) {
    header("Location: ?page=ingredient");
}

$idIngredient = $_GET['id'];

use Model\Ingredient;

$ingredientController = new Ingredient;

$read = $ingredientController->readById($_GET['id']);

if (!$read) {
    header("Location: ?page=ingredient");
    exit();
}

?>

<section class="main-update-ingredient">
    <div class="dashboard-title-wrapper">
        <a href="?page=ingredient">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Atualização</h1>
    </div>

    <form id="form-update-ingredient" class="main-dashboard-form" method="POST">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="update-name-ingredient">Ingrediente</label>
                <input type="text" name="name" id="update-name-ingredient" placeholder="Digite o Ingrediente" value="<?= $read['name'] ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="update-price-ingredient">Preço</label>
                <input type="text" id="update-price-ingredient" name="price" class="input-mask-money" placeholder="Digite o Preço" value="<?= number_format($read['price'], 2, ',', '.') ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="update-status-ingredient">Status</label>
                <select name="status" id="update-status-ingredient" required>
                    <option value="1" <?= 1 == $read['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="0" <?= 0 == $read['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-update-ingredient" class="button-submit success" data-ingredient-id="<?= $read['ingredient_id'] ?>">Atualizar</button>
        <button type="button" id="button-delete-ingredient" class="button-submit delete" data-ingredient-id="<?= $read['ingredient_id'] ?>">Deletar</button>
    </form>
</section>