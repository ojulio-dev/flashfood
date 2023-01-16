<?php

use Model\Ingredient;

$ingredientController = new Ingredient;

$readIngredients = $ingredientController->readAdmin();

?>

<section class="main-ingredient-products">
    <div class="dashboard-title-wrapper">
        <h1 class="main-dashboard-title">Adicionais</h1>
    </div>

    <div class="products-search-wrapper">
        <div class="search-form">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="ingredient-search" type="search" placeholder="Search...">
        </div>
        
        <a href="?page=ingredient&action=create" class="products-read-button-create">Create +</a>
    </div>

    <div class="read-table-scroll-wrapper">
        <table class="main-read-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ingredientes</th>
                    <th>Preços</th>
                    <th>Status</th>
                    <th class="read-table-action">Action</th>
                </tr>
            </thead>
            <tbody id="read-table-ingredients-items">
                <?php if ($readIngredients): foreach($readIngredients as $ingredient): $count = $ingredientController->countIngredients($ingredient['ingredient_id'])?>
                    <tr>
                        <td><?= $ingredient['ingredient_id'] ?></td>
                        <td><?= $ingredient['name'] ?></td>
                        <td>R$ <?=  number_format($ingredient['price'], 2, ',', '.') ?></td>
                        <td class="read-table-status">
                            <form>
                                <input name="status-read-ingredient" id="status-read-ingredient" onclick="changeStatus(<?= $ingredient['ingredient_id'] ?>, 'ingredient')" type="checkbox" <?= $ingredient['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status"></label>
                            </form>
                        </td>
                        <td class="read-table-action">
                            <div class="read-table-icons-wrapper">
                                <a href="?page=ingredient&action=update&slug=<?= $ingredient['slug'] ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php  endforeach; else: ?>
                    <tr>
                        <td colspan="5">Nenhum Ingrediente cadastrado, cadastre clicando <a class="link-no-results" href="?page=ingredient&action=create">aqui</a></td> 
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>