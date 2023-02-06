// Mudar a quantidade de Produtos
$('.button-product-quantity').click(function() {
    let productQuantity = parseFloat($('#input-product-quantity').val());

    let buttonAction = $(this).data('action');

    let value;

    if (buttonAction == 'adicionar') {
        value = parseInt(productQuantity) + 1;
    } else {
        value = parseInt(productQuantity) - 1;
    }

    $('#input-product-quantity').val(value);

    $('#input-product-quantity').trigger('change');

    // Button Price
    // Preço do Produto mais os Adicionais;
    let productAdditionalPrice = parseFloat($('.sistema-info-wrapper').data('product-price')) + parseFloat($('.sistema-info-wrapper').data('additional-current-price'));

    if (value < 1) {

        value = 1;
    } else if (value > 9) {

        value = 9;
    }

    // Preço do Produto vezes a Quantidade
    let productPrice = parseFloat($('.sistema-info-wrapper').data('product-price')) * value;

    // Preço do Produto mais os Adicionais vezes a Quantidade;
    let buttonValue = productAdditionalPrice * value;

    if (value < 1) {
        buttonValue = productAdditionalPrice;
    } else if (value > 9) {
        buttonValue = productAdditionalPrice * 9;
    }

    const priceFormat = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(buttonValue);

    $('#adicionar-carrinho #cart-product-price').html(priceFormat);

    $('.sistema-info-wrapper').data('product-current-price', productPrice);
})

$('body').on('change', '#input-product-quantity', function() {
    
    let productQuantity = $(this).val();

    if (productQuantity < 1) {
        $(this).val(1);

        productQuantity = 1;
    } else if (productQuantity > 9) {
        $(this).val(9);

        productQuantity = 9;
    }

    // fazer a atualização no banco...
})

// Mudar a quantidade de Adicionais
$('.btn-additional-product').click(function(){
    let additionalWrapper =  $(this).closest('[data-additional-id]');

    let additionalInput = additionalWrapper.find('input');

    let additionalQuantity = additionalInput.val();

    let buttonAction = $(this).data('action');

    let value;

    if (buttonAction == 'adicionar'){
        value = parseInt(additionalQuantity) + 1;

    } else {
        value = parseInt(additionalQuantity) - 1;
        
    }

    additionalInput.val(value);

    additionalInput.trigger('change');

    // Button Price
    let additionalPrice = parseFloat($(this).closest('li').data('additional-price'));

    if (value < 0 || value > 9) {

        additionalPrice = 0;

    }

    let currentAdditionalPrice = parseFloat($('.sistema-info-wrapper').data('additional-current-price'));
    
    if (buttonAction == 'adicionar') {

        currentAdditionalPrice = currentAdditionalPrice + additionalPrice;

    } else {

        currentAdditionalPrice = currentAdditionalPrice - additionalPrice;

    }

    $('.sistema-info-wrapper').data('additional-current-price', currentAdditionalPrice);

    let productPrice = parseFloat($(this).closest('[data-product-price]').data('product-current-price'));

    productPrice = productPrice + (currentAdditionalPrice * parseFloat($('#input-product-quantity').val()));
    
    console.log(productPrice);
    

    const priceFormat = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(productPrice);

    $('#adicionar-carrinho #cart-product-price').html(priceFormat);
})

$('body').on('change', '#input-additional-quantity', function(){

    let additionalQuantity = $(this).val();

    if(additionalQuantity < 0){
        $(this).val(0);

        additionalQuantity = 0;
    } else if (additionalQuantity > 9) {
        $(this).val(9);

        additionalQuantity = 9;
    }
    
})

// adicionar ao carrinho

$('#adicionar-carrinho').click(function() {

    let productId = $('.sistema-info-wrapper').data('product-id');

    let productQuantity = $('.sistema-info-wrapper #input-product-quantity').val();

    let note = $('.input-modal-obs').val()

    let additionals = [];

    let additionalsInput = $('.sistema-info-wrapper #input-additional-quantity');

    if (additionalsInput.length) {
        additionalsInput.map(function(_, additional) {

            let quantity = $(additional).val();

            if (quantity > 0) {

                additionals = [...additionals, {
                    id: additional.dataset.additionalId,
                    quantity
                }]
            }
        });
    }

    $.ajax({
        url: SERVER_HOST + '/api/?api=cart&action=insertCart',
        type: 'POST',
        data: {
            productId,
            productQuantity,
            additionals,
            note
        },
        dataType: 'json',
        success: function() {

            Swal.fire({
                title: 'Tudo certo!',
                text: 'Seu Produto foi adicionado ao Carrinho!',
                showCancelButton: true,
                confirmButtonColor: '#52A84B',
                cancelButtonColor: '#7066e0',
                confirmButtonText: 'Continuar',
                cancelButtonText: `Ficar aqui`,
                icon: 'success'
              }).then((result) => {

                if (result.isConfirmed) {
                
                    window.location = `?page=menu`;
        
                } else {
                    
                    readCartIcon();
                }
            })

        },
        error: function() {

            Swal.fire({
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })

        }
    })
})