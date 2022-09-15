<?php

use Dashboard\Model\ItemCategory;
use Dashboard\Model\Item;

$itemCategory = new ItemCategory;

$categories = $itemCategory->read();

if (isset($_POST['submit'])) {
    $isEmpty = false;

    foreach($_POST as $postItem) {
        if (empty($postItem)) {
            $isEmpty = true;
        }
    }

    if ($isEmpty) {
        $_SESSION['flash']['message'] = 'Digite as informações!';
        $_SESSION['flash']['color'] = 'danger';

        header("Location: index.php?page=item&action=create");
        exit();
    }

    DEFINE('NAME', filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
    DEFINE('CATEGORY', filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT));
    DEFINE('PRICE', filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT));
    DEFINE('SPECIAL_PRICE', filter_input(INPUT_POST, 'special_price', FILTER_SANITIZE_NUMBER_FLOAT));
    DEFINE('DESCRIPTION', filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
    DEFINE('STATUS', filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT));
    DEFINE('SLUG', strtolower(str_replace(' ', '-', NAME)));
}

?>

<div class="products-title-wrapper">
    <a href="?page=item"><i class="fa-solid fa-arrow-left fa-lg"></i></a>
    <h1 class="products-create-title">Cadastro de Produto</h1>
</div>

<form method="POST" class="main-create-form" enctype="multipart/form-data">
    <div class="products-create">
        <div class="input-create-wrapper">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" placeholder="Digite o Nome" required>
        </div>

        <div class="input-create-wrapper">
            <label for="category">Categoria</label>
            <select name="category" id="category" required>
                <option value="" selected>Selecione uma Categoria</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="input-create-wrapper">
            <label for="price">Preço</label>
            <input type="number" name="price" id="price" step="0.01" placeholder="R$ 100,99" required>
        </div>

        <div class="input-create-wrapper">
            <label for="special_price">Desconto</label>
            <input type="number" name="special_price" id="special_price" step="0.01" placeholder="R$ 50,99" required>
        </div>

        <div class="input-create-wrapper">
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" placeholder="Digite a Descrição" required>
        </div>

        <div class="input-create-wrapper">
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="1" selected>Ativado</option>
                <option value="0">Desativado</option>
            </select>
        </div>

        <div class="input-create-wrapper">
            <label for="banner">Banner</label>
            <input type="file" name="banner" id="banner" required>
        </div>
    </div>

    <input type="submit" value="Cadastrar" name="submit" id="submit">
</form>