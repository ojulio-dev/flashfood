<?php

use Model\Product;
use Model\ProductCategory;

$product = new Product;

$productCategory = new ProductCategory;

$readProduct = $product->read();

$readCategory = $productCategory->read();

?>

<section id="main-read-products" class="main-read-products">
    <div class="products-title-wrapper">
        <h1 class="main-products-title">Produtos</h1>
    </div>

    <form class="products-select-category">
        <select id="options-list-products">
            <option value="all" selected>Todos</option>

            <?php foreach($readCategory as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach ?>
        </select>
    </form>

    <div class="read-table-wrapper">
        
        <table>
            <tbody id="read-table-products-items">
                <?php if ($readProduct): foreach($readProduct as $product): ?>
                    <tr>
                        <td class="read-image-wrapper"><img src="assets/images/products/<?= $product['banner'] ?>" alt=""></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td>R$ <?= number_format($product['special_price'], 2, ',', '.') ?></td>
                        <td class="read-table-status">
                            <form>
                                <input name="status" id="status-read-products" type="checkbox" onclick="changeStatus(<?= $product['product_id']?>, 'product')" <?= $product['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status-read-products"></label>
                            </form>
                        </td>
                        <td>
                            <div class="read-icons-wrapper">
                                <a class="read-icons-action" href="?page=products&action=update&slug=<?= $product['slug'] ?>">
                                    <img src="<?= DIR_IMG ?>/system/editar.png">
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