// Modal Observação
$('#button-modal-obs').click(function(){
    $('#main-modal-obs').show()
})

$('#cancelar-modal-obs,#modal-obs-close').click(function(){
    $('#main-modal-obs').hide()
    $('.input-modal-obs').val("")
})

$('#enviar-modal-obs').click(function(){
    $('#main-modal-obs').toggle()
})

// Modal Menu Hamburguer
$('.header-menu-wrapper #header-burguer-icon').click(function() {
    $('#modal-header-menu').css('display', 'flex');

    $('#modal-header-menu .modal-wrapper').addClass('header-menu-animation');
}) 

$('#modal-header-menu #close-modal-header,#header-menu-close').click(function() {
    $('#modal-header-menu').hide();
})

$('.header-responsivo .header-search-wrapper .header-button-search').click(function() {
    let inputWidth = $('.header-responsivo .header-search-wrapper input').css('width');

    if (inputWidth == '65px') {
        $('.header-responsivo .header-search-wrapper').css('width', '100%');

        $('.header-responsivo > a img').css('opacity', '0');

        $('.header-responsivo .header-search-wrapper input').css('width', 'calc(100% - 15px)');
    } else {
        $('.header-responsivo > a img').css('opacity', '1');

        $('.header-responsivo .header-search-wrapper input').css('width', '65px');

        $('.header-responsivo .header-search-wrapper').css('width', '65px');
    }
})

$('.itens-cardapio').click(function(){
    let productSlug = $(this).data('product-slug');

    window.location.href = `?page=menu&action=product&slug=${productSlug}`;
})

// adicionar ao carrinho

$('#adicionar-carrinho').click(function() {

    let productId = $('.sistema-info-wrapper').data('product-id');
    let quantity = $('.sistema-info-wrapper #input-product-quantity').val();

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

    return;

    const result = fetch(SERVER_HOST + '/api/?api=cart&action=insertCart', {
        method: 'POST',
        body: `productId=${productId}&productQuantity=${quantity}&additionals=${additionals}`,
        headers: {
            // 'Content-Type': 'application/json'
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then((response) => response.json())
    .then((result) => {
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
    
            }
        })
    })
    .catch(error => {
        Swal.fire({
            title: 'Oops...',
            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
            icon: 'error'
        })
    });

})