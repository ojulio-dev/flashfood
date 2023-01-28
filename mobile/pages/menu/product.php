<?php

use Model\Product;
use Model\Additional;
use Model\Ingredient;

$product = new Product();
$additional = new Additional();
$ingredient = new Ingredient();

if (!isset($_GET['slug'])) {

    header("Location: ?page=menu");
}

$readProduct = $product->readBySlug($_GET['slug']);

if (!$readProduct) {

    header("Location: ?page=menu");
}

$additionals = $additional->readByProductId($readProduct['product_id']);

?>

<section class="sistema-cardapio-wrapper">
    <div class="sistema-info-wrapper" data-product-id="<?= $readProduct['product_id'] ?>" data-product-price="<?= $readProduct['special_price'] ?? $readProduct['price'] ?>" data-product-current-price="<?= $readProduct['special_price'] ?? $readProduct['price'] ?>" data-additional-current-price="0">
        <div class="title-wrapper">
            <h2 class="title-cart-product"><?= $readProduct['name'] ?></h2>
        </div>

        <div class="caixa-img-strong">
            <img class="img" src="<?= $readProduct['banner'] ?>" alt="">
        </div>
        <div class="especificacoes-produto">
            <div class="texto-produto">
                <img src="<?= DIR_IMG ?>/header/logo-responsivo.png" alt="" class="logo-especificacao">
                <h4><?= $readProduct['description'] ?></h4>
            </div>
            <div class="preco-produto">
                <h5>R$ <?= number_format($readProduct['special_price'] ?? $readProduct['price'] , 2, ',', '.') ?></h5>
            </div>
        </div>

        <?php if ($additionals): ?>
            <h3 class="titulo-adicionais">Adicionais</h3>
            <div class="main-adicionais-wrapper">
                
                <ul>
                    <?php foreach($additionals as $additional): $ingredients = $ingredient->readById($additional['ingredient_id'])?>
                        <li data-additional-price="<?= $ingredients['price'] ?>">
                            <div class="adicionais-info-wrapper">
                                <h5><?= $ingredients['name'] ?></h5>
                                <small>R$ <?= number_format($ingredients['price'], 2, ',', '.') ?></small>
                            </div>
                            <div class="adicionais-quantidades" data-additional-id="1">
                                <button class="btn-additional-product" data-action="diminuir"><i class="fa-solid fa-minus"></i></button>
                                <input id="input-additional-quantity" type="number" value="0" min="0" max="9" data-additional-id="<?= $additional['additional_id'] ?>">
                                <button class="btn-additional-product" data-action="adicionar"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="quantidade-observacao">
            <div class="quantidade-grid">
                <div class="adicionais-quantidades" data-additional-id="1">
                    <button class="button-product-quantity btn-minus" data-action="diminuir"><i class="fa-solid fa-minus"></i></button>
                    <input id="input-product-quantity" type="number" value="1" min="1" max="99" data-button-action="adicionar">
                    <button class="button-product-quantity btn-plus" data-action="adicionar"><i class="fa-solid fa-plus"></i></button>
                </div>
                <h5>Quantidade</h5>
            </div>
            <div class="quantidade-grid">
                <i class="fa-regular fa-2x fa-pen-to-square" id="button-modal-obs"></i>
                <h5>Adicionar Observação</h5>
            </div>
        </div>
        
        <div class="btn-adicionar-grid">
            <button id="adicionar-carrinho" class="btn-adicionar-carrinho">Adicionar ao carrinho  (<span id="cart-product-price">R$ <?= number_format($readProduct['special_price'] ?? $readProduct['price'], 2, ',', '.') ?></span>)</button>
        </div>
    </div>

    <!-- div modal -->
    <div id="main-modal-obs" class="main-modal-mobile">
        <div id="modal-obs-close" class="modal-mobile-close"></div>

        <div class="modal-obs-wrapper">
            <div class="obs-titulo">
                <h2>Adicionar Observação</h2>
            </div>

            <input type="text" class="input-modal-obs" placeholder="Qual a sua observação?">

            <div class="obs-button">
                <button class="obs-modal-cancelar" id="cancelar-modal-obs">Cancelar</button>
                <button class="obs-modal-enviar" id="enviar-modal-obs">Enviar</button>
            </div>
        </div>
    </div>
</section>