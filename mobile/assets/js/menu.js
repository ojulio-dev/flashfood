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