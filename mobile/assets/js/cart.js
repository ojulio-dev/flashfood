// --------------------modal quantidade-----------------------

$('body').on('click', '.button-modal-quantity', function(){
    let productQuantity = $(this).html();

    let cartId = $(this).data('cart-id');

    $('#main-modal-quantity #modal-input-product-quantity').val(productQuantity);

    $('#main-modal-quantity #modal-input-product-quantity').data('cart-id', cartId);

    $('#main-modal-quantity').show();
})

$('body').on('click', '#cancelar-modal-quantity, #modal-quantity-close', function() {

    $('#main-modal-quantity').hide();

})

$('body').on('click', '#salvar-modal-quantity', function() {

    let cartId = $('#main-modal-quantity #modal-input-product-quantity').data('cart-id');

    let productQuantity = $('#main-modal-quantity #modal-input-product-quantity').val();

    const result = fetch(`${SERVER_HOST}/api/?api=cart&action=changeQuantity`, {
        body: `cartId=${cartId}&quantity=${productQuantity}`,
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then((response) => response.json())
    .then((result) => {

        if (result) {

            $('#main-modal-quantity').hide();

            readCart();

        }

    })
    .catch(error => {

        $('#main-modal-quantity').hide();

        Swal.fire({
            title: 'Oops...',
            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
            icon: 'error'
        })

    })
})

$('body').on('click', '.button-modal-product-quantity', function() {
    let modalProductQuantity = $('#modal-input-product-quantity').val();

    let buttonAction = $(this).data('action');

    let value;

    if (buttonAction == 'adicionar') {
        value = parseInt(modalProductQuantity) + 1;
    } else {
        value = parseInt(modalProductQuantity) - 1;
    }

    $('#modal-input-product-quantity').val(value);

    $('#modal-input-product-quantity').trigger('change');
})

$('body').on('change', '#modal-input-product-quantity', function() {
    
    let modalProductQuantity = $(this).val();

    if (modalProductQuantity < 1) {
        $(this).val(1);

        modalProductQuantity = 1;
    } else if (modalProductQuantity > 9) {
        $(this).val(9);

        modalProductQuantity = 9;
    }

    // fazer a atualização no banco...
})

// --------------------modal adicional-----------------

$('body').on('click', '.button-modal-additional', function() {
    if ($(this).html() <= 0) {
        return false;
    }

    let cartId = $(this).data('cart-id');

    const result = fetch(`${SERVER_HOST}/api/?api=cart&action=listCartAdditionals`, {
        body: `cartId=${cartId}`,
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          }
    })
    .then((response) => response.json())
    .then((result) => {

        $('#main-modal-additional .content-additional').html('');

        result.map(additional => {
            let additionalPrice = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(additional.price);

            $('#main-modal-additional .content-additional').append(`
                <li>
                    <h3 class="additional-orders">(${additional.quantity}) ${additional.name} </h3>
                    <h3 class="additional-value additional-orders">${additionalPrice}</h3>
                </li>
            `);
        })

        $('#main-modal-additional').show();
    })
    .catch(error => {

        Swal.fire({
            title: 'Oops...',
            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
            icon: 'error'
        })

    })
})

$('#modal-additional-close').click(function(){
    $('#main-modal-additional').hide()
})

// -----------cancelar pedido-----------
$('body').on('click', '.carrinho-cancelar-pedido', function() {
    let nomePedidoCancelar = $(this).data('product-name');

    Swal.fire({
        title: 'Confirmação',
        icon: 'warning',
        html: `Tem certeza que deseja remover <b>${nomePedidoCancelar}</b> do carrinho?`,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#52A84B',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {

        if (result.isConfirmed) {

            let cartId = $(this).data('cart-id');

            const result = fetch(`${SERVER_HOST}/api/?api=cart&action=removeProduct`, {
                body: `cartId=${cartId}`,
                method: 'POST',
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then((response) => response.json())
            .then((result) => {

                readCart();

                Swal.fire({
                    title: 'Feito!',
                    text: 'O Produto foi removido do Carrinho!',
                    icon: 'success'
                })

            })
            .catch(error => {

                Swal.fire({
                    title: 'Oops...',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })

            })
        }

      })
})

const readCart = () => {

    const result = fetch(`${SERVER_HOST}/api/?api=cart&action=listCart`)
    .then((response) => response.json())
    .then((result) => {

        $('.products-cart-wrapper').html('');

        if (result.readCart.length) {

            result.readCart.map(product => {

                let productPrice = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }).format(product.special_price ?? product.price);

                let totalPrice = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }).format(result.totalPrice);
    
                $('.products-cart-wrapper').append(`
                    <div class="product-cart-wrapper">
                        <div class="caixa-img-carrinho">
                            <div class="caixa-image">
                                <a href="?page=menu&action=product&slug=${product.slug}"><img src="${SERVER_HOST}/assets/images/products/${product.banner}" alt=""></a>
                            </div>
                            <div class="produto-carrinho">
                                <div class="carrinho-titulo-wrapper">
                                    <h3>${product.name}</h3>
                                </div>
                                <div class="quantidade-carrinho">
                                    <h4>Quantidade:</h4>
                                    <button class="btn-quantidade-adicionais button-modal-quantity" data-cart-id="${product.cart_id}">${product.quantity}</button>
                                </div>
    
                                <div class="carrinho-adicionais-wrapper">
                                    <h4>Adicionais:</h4>
                                    <button class="btn-quantidade-adicionais button-modal-additional" data-cart-id="${product.cart_id}">${product.additionalsQuantity}</button>
                                </div>
                                
                                <div class="caixa-cancelar">
                                    <strong>${productPrice}</strong>
                                    <button class="carrinho-cancelar-pedido" data-product-name="${product.name}" data-cart-id="${product.cart_id}">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                $('.div-finalizar strong').html('Total: ' + totalPrice);
    
            })
        } else {

            $('.products-cart-wrapper').html(`
                <span class="notfound">Puts, seu carrinho está vazio. Dê uma olhadinha nas novidades do <a href="?page=menu">Cardápio!</a></span>
            `);

            $('.div-finalizar').addClass('notfound');
            $('.div-finalizar #button-cancel-order, .div-finalizar #finalizar-pedido').prop('disabled', true);

        }

    })

}

// ---------- finalizar pedido -----------
$('body').on('click', '#finalizar-pedido', function() {

    $('#cart-modal-tables').show();

})

$('#modal-tables-close').click(function() {
    $('#cart-modal-tables').hide();
})

$('#cart-modal-tables .tables-wrapper li').click(function() {

    $('#cart-modal-tables').hide();

    let tableId = $(this).data('table-id');

    const result = fetch(`${SERVER_HOST}/api/?api=cart&action=finishOrder`, {
        method: 'POST',
        body: `tableId=${tableId}`,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then((response) => response.json())
    .then((result) => {

        readCart();

        if (result.response) {

            Swal.fire({
                icon: 'success',
                title: 'Prontinho',
                html: `O pedido número <b>#${result.orderNumber}</b> da mesa <b>${result.tableNumber}</b> será entregue a cozinha imediatamente. O FlashFood agradece`
            })

        } else {

            Swal.fire({
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })

        }

    })
    .catch(error => {

        Swal.fire({
            title: 'Oops...',
            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
            icon: 'error'
        })

    })
})

$('#button-cancel-order').click(function() {
    Swal.fire({
        title: 'Atenção!',
        text: 'Tem certeza que deseja cancelar o Pedido?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: SERVER_HOST + '/api/?api=cart&action=removeCart',
                dataType: 'json',
                success: function(data) {

                    readCart();
                    
                    if (data.response) {

                        Swal.fire({
                            title: 'Tudo Certo!',
                            text: 'Pedido cancelado com Sucesso',
                            icon: 'success'
                        })

                    }

                },
                error: function() {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                        icon: 'error'
                    })
                }
            })
        }

    })
})