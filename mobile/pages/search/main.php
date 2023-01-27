<?php

use Model\Product;

$product = new Product();

if (!isset($_GET['q'])) {

    header("Location: ?page=menu");
}

$products = $product->readBySearch($_GET['q']);

?>

<section class="main-page-search section-products page-footer">
    <div class="home-products-wrapper page-footer">
        <?php if ($products): ?>
            <span class="search-message"><i class="fa-solid fa-magnifying-glass"></i> Resultados para "<?= $_GET['q'] ?>"</span>

            <?php foreach($products as $product): ?>
                <div class="itens-cardapio" data-product-slug="<?= $product['slug'] ?>">
                    <div class="fundo-produto">
                        <h2 class="main-titulo-produto"><?= $product['name'] ?></h2>
                        <div class="img-produto">
                            <img src="<?= $product['banner'] ?>" alt="">
                        </div>
                        <div class="especificacoes-produto">
                            <div class="texto-produto">
                                <img src="<?= DIR_IMG ?>/header/logo-responsivo.png" alt="" class="logo-especificacao">
                                <h4><?= $product['description'] ?></h4>
                            </div>
                            <div class="preco-produto">
                                <h5>R$ <?=  number_format($product['special_price'] ?? $product['price'], 2, ',', '.') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <span class="search-message"><i class="fa-regular fa-face-frown-open"></i> "<?= $_GET['q'] ?>" não retornou resultados</span>
        <?php endif; ?>
    </div>

    <div class="main-footer">
        <div class="info-wrapper">
            <div class="images-wrapper">
                <img src="<?= SERVER_HOST ?>/assets/images/system/facebook.png" alt="Facebook Icon">
                <img src="<?= SERVER_HOST ?>/assets/images/system/instagram.png" alt="Instagram Icon">
                <img src="<?= SERVER_HOST ?>/assets/images/system/twitter.png" alt="Twitter Icon">
            </div>

            <small>© 2023 Copyright - Todos os direitos reservados</small>
        </div>
    </div>
</section>