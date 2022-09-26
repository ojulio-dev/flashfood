<?php

if (!isset($_GET['id'])) {
    header("Location: index.php?page=category");
}

use Dashboard\Model\ProductCategory;

$productCategory = new ProductCategory;

$read = $productCategory->readById($_GET['id']);

if (!$read) {
    header("Location: index.php?page=category");
    exit();
}

if (isset($_POST['submit'])) {

    $isEmpty = false;
    
    foreach($_POST as $postItem) {
        if (empty(trim($postItem))) {
            $isEmpty = true;
        }
    }

    if ($isEmpty) {

        header("Location: index.php?page=category&action=update?id=" . $_GET['id'] . "");
        exit();
    }

    $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $data['category_id'] = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));
    $data['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

    $update = $productCategory->update($data);

    if ($update) {
        header("Location: index.php?page=category");

        exit();
    } else {
        header("Location: index.php?page=products&action=update" . $_GET['id'] . "");

        exit();
    }

}

$readProducts = $productCategory->readByCategory($_GET['id']);

?>

<section class="main-update-category">
    <div class="products-title-wrapper">
        <a href="?page=category">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-products-title">Atualização de Categorias</h1>
    </div>

    <form class="main-products-form" method="POST">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="name">Categoria</label>
                <input type="text" name="name" id="name" placeholder="Digite a Categoria" value="<?= $read['name'] ?>" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="'1'" <?= 1 == $read['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="'0'" <?= 0 == $read['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>
        </div>

        <input type="submit" value="Atualizar" name="submit" id="submit">
    </form>

    <div class="read-table-wrapper category">
        <table>
            <tbody>
                <?php if ($readProducts): foreach($readProducts as $product): ?>

                    <tr>
                        <td class="read-image-wrapper"><img src="assets/images/products/<?= $product['banner'] ?>" alt=""></td>
                        <td><?= $product['name'] ?></td>
                        <td>R$ <?= number_format($product['special_price'], 2, ',', '.'); ?></td>
                        <td class="product-table-status <?= $product['status'] ? 'active' : 'disabled' ?>"><?= $product['status'] ? 'Ativo' : 'Desativado' ?></td>
                        <td>
                            <div class="read-icons-wrapper">
                                <a class="read-icons-action" href="?page=products&action=update&id=<?= $product['product_id'] ?>">
                                   <img src="<?= DIR_IMG ?>/system/editar.png">
                                </a>
                                <a class="read-icons-action" href="?page=products&action=delete&id=<?= $product['product_id'] ?>">
                                    <i class="fa-solid fa-trash fa-solid-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                <?php  endforeach; else: ?>
                    <tr>
                        <td>Nenhum Produto cadastrado, cadastre clicando aqui <a href="?page=products&action=create"><i class="fa-solid fa-arrow-right"></i></a></td>
                    </tr>
                <?php endif; ?>
                
            </tbody>
        </table>
    </div>
</section>