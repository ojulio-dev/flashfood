<?php

use Model\Product;

$product = new Product;

$read = $product->read();

?>

<section id="main-read-products" class="main-read-products">
    <div class="products-title-wrapper">
        <h1 class="main-products-title">Produtos</h1>
    </div>

    <div class="read-table-wrapper">
        <table>
            <tbody id="read-table-products-items">
                <?php if ($read): foreach($read as $product): ?>
                    <tr>
                        <td class="read-image-wrapper"><img src="assets/images/products/<?= $product['banner'] ?>" alt=""></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td>R$ <?= number_format($product['special_price'], 2, ',', '.') ?></td>
                        <td class="product-table-status">
                            <form>
                                <input id="status" name="status" type="checkbox" onclick="changeStatus(<?= $product['product_id']?>, 'product')" <?= $product['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status"></label>
                            </form>
                        </td>
                        <td>
                            <div class="read-icons-wrapper">
                                <a class="read-icons-action" href="?page=products&action=update&id=<?= $product['product_id'] ?>">
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