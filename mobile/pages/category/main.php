<?php

use Model\ProductCategory;

$productCategory = new ProductCategory();

if (!isset($_GET['slug'])) {
  header("Location: ?page=menu");
}

$category = $productCategory->readBySlug($_GET['slug']);

$categories = $productCategory->read();

if (!$category) {
  header("Location: ?page=menu");
}

$products = $productCategory->readProductsBySlug($_GET['slug']);

?>

<section id="main-category-products" class="section-products">
    <div class="categories-wrapper">
        <div class="items-categories">
            <ul>
                <?php foreach($categories as $category): ?>
                    <a href="?page=category&slug=<?= $category['slug'] ?>">
                        <li <?= $category['slug'] == $_GET['slug'] ? 'class="active"' : ''?>>
                            <img src="<?= SERVER_HOST ?>/assets/images/categories/<?= $category['banner'] ?>" alt="Imagem do Produto">

                            <h2><?= $category['name'] ?></h2>
                        </li>
                    </a>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="home-products-wrapper page-footer">
        <?php foreach($products as $product): ?>
            <div class="itens-cardapio" data-product-slug="<?= $product['slug'] ?>">
                <div class="fundo-produto">
                    <h2 class="main-titulo-produto"><?= $product['name'] ?></h2>
                    <div class="img-produto">
                        <img src="<?= $product['banner'] ?>" alt="">
                    </div>
                    <div class="especificacoes-produto">
                        <div class="texto-produto">
                            <img src="<?= DIR_MOBILE ?>/assets/images/header/logo-responsivo.png" alt="" class="logo-especificacao">
                            <h4><?= $product['description'] ?></h4>
                        </div>
                        <div class="preco-produto">
                            <h5>R$ <?=  number_format($product['special_price'] ?? $product['price'], 2, ',', '.') ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="main-footer">
        <div class="info-wrapper">
            <div class="images-wrapper">
                <img src="<?= SERVER_HOST ?>/assets/images/system/facebook.png" alt="Facebook Icon">
                <img src="<?= SERVER_HOST ?>/assets/images/system/instagram.png" alt="Instagram Icon">
                <img src="<?= SERVER_HOST ?>/assets/images/system/twitter.png" alt="Twitter Icon">
            </div>

            <small>@ 2023 FlashFood - Todos os diretos reservados</small>
        </div>
    </div>
</section>