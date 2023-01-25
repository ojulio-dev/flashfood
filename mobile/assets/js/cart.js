// modal quantidade

$('#button-modal-quantity').click(function(){
    $('#main-modal-quantity').show()
})

$('#cancelar-modal-quantity,#modal-quantity-close').click(function(){
    $('#main-modal-quantity').hide()
})

$('#salvar-modal-quantity').click(function(){
    $('#main-modal-quantity').toggle()
})


// --------------Mudar a quantidade de Produtos------------------

$('.button-modal-product-quantity').click(function() {
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

    if (modalProductQuantity < 1 || modalProductQuantity > 99) {
        $(this).val(1);

        modalProductQuantity = 1;
    }

    // fazer a atualização no banco...
})
