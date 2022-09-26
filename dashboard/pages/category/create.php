<?php

use Dashboard\Model\ProductCategory;

$productCategory = new ProductCategory;

if (isset($_POST['submit'])) {
    $isEmpty = false;

    foreach($_POST as $postItem) {
        if (empty($postItem)) {
            $isEmpty = true;
        }
    }

    if ($isEmpty) {
        
        header("Location: index.php?page=category&action=create");
        exit();
    }

    $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

    if (!$data['name'] && !$data['slug'] && !$data['status']) {
        header("Location: index.php?page=category");
        exit();
    }

    $create = $productCategory->create($data);

    if ($create) {
        header("Location: index.php?page=category");

        exit();
    } else {
        header("Location: index.php?page=category&action=create");

        exit();
    }
}

?>

<section class="main-create-category">
    <div class="products-title-wrapper">
        <a href="?page=category">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-products-title">Cadastro de Categorias</h1>
    </div>

    <form class="main-products-form" method="POST">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="name">Categoria</label>
                <input type="text" name="name" id="name" placeholder="Digite a Categoria" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>
        </div>

        <input type="submit" value="Cadastrar" name="submit" id="submit">
    </form>
</section>