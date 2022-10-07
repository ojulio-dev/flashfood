<?php

use Model\ProductCategory;

$productCategory = new ProductCategory;

$read = $productCategory->readAll();

?>

<section class="main-category-products">
    <div class="products-title-wrapper">
        <h1 class="main-products-title">Categorias</h1>
    </div>

    <div class="category-search-wrapper">
        <form class="category-search-form">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Search...">
        </form>
        <a href="?page=category&action=create" class="category-button-create">Create +</a>
    </div>

    <div class="category-table-scroll-wrapper">
        <table class="category-read-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Categoria</th>
                    <th>Produtos</th>
                    <th>Status</th>
                    <th class="category-table-action">Action</th>
                </tr>
            </thead>
            <tbody id="read-table-category-items">
                <?php if ($read): foreach($read as $category): $count = $productCategory->countProducts($category['category_id'])?>
                    <tr>
                        <td><?= $category['category_id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td>
                            <?= $count > 0 ? $count : 'Nenhum' ?> <?= $count <= 1 ? 'Produto' : 'Produtos' ?>
                        </td>
                        <td class="product-table-status">
                            <form>
                                <input name="status" onclick="changeStatus(<?= $category['category_id'] ?>, 'category')" type="checkbox" <?= $category['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status"></label>
                            </form>
                        </td>
                        <td class="category-table-action">
                            <div class="category-icons-wrapper">
                                <a href="index.php?page=category&action=update&id=<?= $category['category_id'] ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php  endforeach; else: ?>
                    <tr>
                        <td>Nenhuma Categoria cadastrada, cadastre clicando <a class="link-no-results" href="?page=category&action=create">aqui</a></td> 
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>