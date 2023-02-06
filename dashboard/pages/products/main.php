<?php

use Model\Product;
use Model\ProductCategory;

$product = new Product;

$productCategory = new ProductCategory;

$readProduct = $product->readAdmin();

$readCategory = $productCategory->read();

?>

<section id="main-read-products" class="main-read-products">
    <div class="dashboard-title-wrapper">
        <h1 class="main-dashboard-title">Produtos</h1>
    </div>

    <form class="main-select-form -products">
        <select id="options-list-wrapper">
            <option value="all" selected>Todos</option>

            <?php foreach($readCategory as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach ?>
        </select>
    </form>

    <div class="read-table-wrapper">
        
        <table>
            <tbody id="main-read-table-items">
                <?php if ($readProduct): foreach($readProduct as $product): ?>
                    <?php $product['final_price'] = number_format($product['special_price'] ?? $product['price'], 2, ',', '.') ?>

                    <tr>
                        <td class="read-image-wrapper"><img src="<?= $product['banner'] ?>" alt=""></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td>R$ <?= $product['final_price'] ?></td>
                        <td class="read-table-status">
                            <form>
                                <input name="status" id="status-read-products" type="checkbox" onclick="changeStatus(<?= $product['product_id']?>, 'product')" <?= $product['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status-read-products"></label>
                            </form>
                        </td>
                        <td>
                            <div class="read-icons-wrapper">
                                <a class="read-icons-action" href="?page=products&action=update&slug=<?= $product['slug'] ?>">
                                    <img src="<?= DIR_DASHBOARD ?>/assets/images/system/editar.png">
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php  endforeach; else: ?>
                    <tr>
                        <td>Nenhum Produto cadastrado, cadastre clicando <a class="link-no-results" href="?page=products&action=create">aqui</a></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>