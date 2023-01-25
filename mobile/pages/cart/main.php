<section>
    <div class="sistema-cardapio-wrapperr">
        <div class="caixa-img-carrinho">
            <div class="caixa-image">
                <img src="<?= DIR_IMG ?>/carrinho/hamburguer.jpeg" alt="">
            </div>
            <div class="produto-carrinho">
                <div class="carrinho-titulo-wrapper">
                    <h3>Big Burguer</h3>
                </div>
                <div class="quantidade-carrinho">
                    <h4>Quantidade:</h4>
                    <button class="btn-quantidade-adicionais" id="button-modal-quantity">2</button>
                </div>

                <div class="carrinho-adicionais-wrapper">
                    <h4>Adicionais:</h4>
                    <button class="btn-quantidade-adicionais" id="button-modal-additional">1</button>
                </div>
                
                <div class="caixa-cancelar">
                    <strong>R$ 36,00</strong>
                    <button id="cancelar-pedido">cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="div-finalizar">
        <div>
            <strong>Total: R$ 258.49</strong>
        </div>
        <div>
            <button>Finalizar pedido</button>
        </div>
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
                <input id="modal-input-product-quantity" class="color-quantity-background" type="number" value="2" min="1" max="99">
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

        <div class="modal-obs-wrapper">
            <div class="obs-titulo">
                <h2>Adicionais Selecionados</h2>
            </div>

            

            <div class="obs-button">
                <button class="obs-modal-cancelar" id="cancelar-modal-additional">Cancelar</button>
                <button class="obs-modal-enviar" id="salvar-modal-additional">Salvar</button>
            </div>
        </div>
    </div>

</section>