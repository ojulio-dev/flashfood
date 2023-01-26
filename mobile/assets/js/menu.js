// Mudar a quantidade de Produtos
$('.button-product-quantity').click(function() {
    let productQuantity = $('#input-product-quantity').val();

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

    let productPrice;

    if (buttonAction == 'adicionar') {

        productPrice = $('.sistema-info-wrapper').data('product-current-price');
    } else {
        
        productPrice = $('.sistema-info-wrapper').data('product-price');
    }
})

$('body').on('change', '#input-product-quantity', function() {
    
    let productQuantity = $(this).val();

    if (productQuantity < 1 || productQuantity > 99) {
        $(this).val(1);

        productQuantity = 1;
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

    if(buttonAction == 'adicionar'){
        value = parseInt(additionalQuantity) + 1;
    }else{
        value = parseInt(additionalQuantity) - 1;
    }

    additionalInput.val(value);

    additionalInput.trigger('change');

    // Button Price
    let additionalPrice = $(this).closest('li').data('additional-price');

    if (value < 0 || value > 9) {

        additionalPrice = 0;

    }

    currentAdditionalPrice = $('.sistema-info-wrapper').data('additional-current-price');

    if (buttonAction == 'adicionar') {

        currentAdditionalPrice = currentAdditionalPrice + additionalPrice;

    } else {

        currentAdditionalPrice = currentAdditionalPrice - additionalPrice;

    }

    $('.sistema-info-wrapper').data('additional-current-price', currentAdditionalPrice);

    let productPrice = $(this).closest('[data-product-price]').data('product-current-price');

    const priceFormat = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(productPrice);

    $('#adicionar-carrinho #cart-product-price').html(priceFormat);

    $('.sistema-info-wrapper').data('product-current-price', productPrice);
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