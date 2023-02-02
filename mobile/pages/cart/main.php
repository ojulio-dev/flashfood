<?php

use Model\Cart\Cart;
use Model\Cart\CartAdditional;
use Model\Table;

$cart = new Cart();
$cartAdditional = new CartAdditional();
$table = new Table();

$readCart = $cart->read($_SESSION['flashfood']['user']['user_id']);

$totalCart = $cart->readTotalPrice($_SESSION['flashfood']['user']['user_id']);

$tables = $table->read();

?>

<style>
    .floating-button-cart {
        display: none;
    }

</style>

<section>
    <div class="products-cart-wrapper">
        <?php if (count($readCart)): ?>
            <?php foreach($readCart as $productCart): ?>

                <div class="product-cart-wrapper">
                    <div class="caixa-img-carrinho">
                        <div class="caixa-image">
                            <a href="?page=menu&action=product&slug=<?= $productCart['slug'] ?>"><img src="<?= SERVER_HOST ?>/assets/images/products/<?= $productCart['banner'] ?>" alt=""></a>
                        </div>
                        <div class="produto-carrinho">
                            <div class="carrinho-titulo-wrapper">
                                <h3><?= $productCart['name'] ?></h3>
                            </div>
                            <div class="quantidade-carrinho">
                                <h4>Quantidade:</h4>
                                <button class="btn-quantidade-adicionais button-modal-quantity" data-cart-id="<?= $productCart['cart_id'] ?>"><?= $productCart['quantity'] ?></button>
                            </div>

                            <div class="carrinho-adicionais-wrapper">
                                <h4>Adicionais:</h4>
                                <button class="btn-quantidade-adicionais button-modal-additional" data-cart-id="<?= $productCart['cart_id'] ?>"><?= $productCart['additionalsQuantity'] ?></button>
                            </div>
                            
                            <div class="caixa-cancelar">
                                <strong>R$ <?= number_format($productCart['special_price'] ?? $productCart['price'], 2, ',', '.') ?></strong>
                                <button class="carrinho-cancelar-pedido" data-product-name="<?= $productCart['name'] ?>" data-cart-id="<?= $productCart['cart_id'] ?>">Remover</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <span class="notfound">Puts, seu carrinho está vazio. Dê uma olhadinha nas novidades do <a href="?page=menu">Cardápio!</a></span>
            <?php endif; ?>
    </div>

    <div class="div-finalizar<?= count($readCart) < 1 ? ' notfound' : '' ?>">
        <div class="buttons-wrapper">
            <button id="button-cancel-order" <?= count($readCart) < 1 ? 'disabled' : '' ?>>Cancelar</button>
            <button id="finalizar-pedido" <?= count($readCart) < 1 ? 'disabled' : '' ?>>Finalizar</button>
        </div>

        <strong>Total: R$ <?= number_format($totalCart, 2, ',', '.') ?></strong>
    </div>

    <!-- modal quantidade -->
    <div id="main-modal-quantity" class="main-modal-mobile">
        <div id="modal-quantity-close" class="modal-mobile-close"></div>

        <div class="modal-obs-wrapper">
            <div class="obs-titulo">
                <h2>Alterar Quantidade</h2>
            </div>

            <div class="adicionais-quantidades color-quantity-background" data-additional-id="1">
                <button class="button-modal-product-quantity btn-minus color-quantity-background" data-action="diminuir"><i class="fa-solid fa-minus"></i></button>
                <input id="modal-input-product-quantity" class="color-quantity-background" type="number" value="1" min="1" max="99" data-cart-id="0">
                <button class="button-modal-product-quantity btn-plus color-quantity-background" data-action="adicionar"><i class="fa-solid fa-plus"></i></button>
            </div>

            <div class="obs-button">
                <button class="obs-modal-cancelar" id="cancelar-modal-quantity">Cancelar</button>
                <button class="obs-modal-enviar" id="salvar-modal-quantity">Salvar</button>
            </div>
        </div>
    </div>

    <!-- Modal adicionais -->
    <div id="main-modal-additional" class="main-modal-mobile">
        <div id="modal-additional-close" class="modal-mobile-close"></div>

        <div class="modal-obs-wrapper additional">
            <div class="obs-titulo">
                <h2>Adicionais Selecionados</h2>
            </div>

            <ul class="content-additional"></ul>
        </div>
    </div>

    <!-- Modal das Mesas -->
    <div id="cart-modal-tables" class="main-modal-mobile">
        <div id="modal-tables-close" class="modal-mobile-close"></div>

        <div class="tables-wrapper">
            <h2>Selecione o Número da Mesa</h2>

            <ul>
                <?php foreach($tables as $table): ?>
                    <li data-table-id="<?= $table['table_id'] ?>"><?= $table['table_number'] ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</section>