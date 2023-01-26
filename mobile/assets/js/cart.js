// --------------------modal quantidade-----------------------

$('#button-modal-quantity').click(function(){
    $('#main-modal-quantity').show()
})

$('#cancelar-modal-quantity,#modal-quantity-close').click(function(){
    $('#main-modal-quantity').hide()
    $('#modal-input-product-quantity').val("2")
})

$('#salvar-modal-quantity').click(function(){
    $('#main-modal-quantity').toggle()
})

// --------------------modal adicional-----------------

$('#button-modal-additional').click(function(){
    $('#main-modal-additional').show()
})

$('#modal-additional-close').click(function(){
    $('#main-modal-additional').hide()
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

// -----------cancelar pedido-----------

var nomePedidoCancelar = 'Big Burguer';

$('#cancelar-pedido').click(function(){
    Swal.fire({
        title: 'Confirmação',
        html: `Tem certeza que deseja remover <b>${nomePedidoCancelar}</b> do carrinho?`,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonColor: '#52A84B',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Seu pedido foi retirado do carrinho.',
          )
        }
      })
})

// ---------- finalizar pedido -----------

$('#finalizar-pedido').click(function(){
    Swal.fire({
        icon: 'success',
        title: 'Seu pedido foi entregue para a cozinha!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function() {
        window.location.href = "?page=home";
    }, 1500);
})
