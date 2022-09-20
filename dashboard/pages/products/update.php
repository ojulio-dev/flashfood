<?php

use Dashboard\Model\Product;

use Dashboard\Model\ProductCategory;

$productCategory = new ProductCategory;

$product = new Product;

$categories = $productCategory->read();

$readProducts = $product->readById($_GET['id']);

if (isset($_POST['submit'])) {
    
    $isEmpty = false;
    
    foreach($_POST as $postItem) {
        if (empty(trim($postItem))) {
            $isEmpty = true;
        }
    }

    if ($isEmpty) {

        header("Location: index.php?page=products&action=update?id=" . $_GET['id'] . "");
        exit();
    }

    if (file_exists($_FILES['banner']['tmp_name'])) {
        $extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

        echo $extension;

        if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png') {

            header("Location: index.php?page=products&action=update" . $_GET['id'] . "");
            exit();
        }
    }

    $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['category_id'] = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $data['price'] = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['special_price'] = filter_input(INPUT_POST, 'special_price', FILTER_SANITIZE_SPECIAL_CHARS);

    $data['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));

    $update = $product->updateById($_GET['id'], $data);

    if ($update) {

        header("Location: index.php?page=read");
        exit();
    } else {

        header("Location: index.php?page=products&action=update" . $_GET['id'] . "");
        exit();
    }
}

?>

<section class="main-update-products">
    <div class="products-title-wrapper">
        <a href="?page=products">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h1 class="main-products-title">Atualização de Produtos</h1>
    </div>

    <form action="" class="main-form-products" method="POST" enctype="multipart/form-data">
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

        <input type="submit" value="Atualizar" name="submit" id="submit">
    </form>
</section>