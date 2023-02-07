// Show Cart Modal
$('.icon-cart-modal').click(function() {

    $('#modal-cart').show();

})

$('body').on('click', '.icon-exit', function() {

    $('.main-modal').hide();

})

$('.main-modal .modal-exit').click(function() {
    $('.main-modal').hide();
})

const readIconCart = () => {
    $.ajax({
        url: SERVER_HOST + '/api/?api=cart&action=listCart',
        dataType: 'json',
        success: function (data) {

            $('#icon-count-cart-items').html(data.readCart.length > 9 ? '9+' : data.readCart.length);
        },
        error: function (jqXhr, textStatus, errorMessage) {
            Swal.fire({
                title: 'Erro!',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })
        }
    });
}

const readCart = () => {
    readIconCart();

    $.ajax({
        url: SERVER_HOST + '/api/?api=cart&action=listCart', 
        dataType: 'json',
        success: function (data) {

            $('.main-item-modal.-cart').html('');

            if (data.readCart.length) {
                data.readCart.map(function(product) {
                    let productPrice = new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(product.special_price ?? product.price);

                    $('.main-item-modal.-cart').append(`
                        <li data-cart-id="${product.cart_id}">
                            <div class="cart-name-wrapper">
                                <i class="fa-solid fa-cart-shopping icon-cart"></i>

                                <div class="cart-info-wrapper">
                                    <h3>${product.name.length > 15 ? product.name.substr(0, 15) + '...' : product.name}</h3>
                                    <p>${productPrice}</p>
                                </div>
                            </div>
                            <div class="cart-edit-amount">
                                <button type="button" class="decrement-product-cart" data-action="decrement"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" value="${product.quantity}" max="99" min="1" class="input-cart-amount">
                                <button type="button" class="increment-product-cart" data-action="increment"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </li>
                    `);
                })

                $('.button-order').prop('disabled', false);
                
            } else {
                $('.main-item-modal.-cart').append(`
                    <li class="cart-empty-wrapper">
                        <p>Você não possui produtos no Carrinho :/</p>
                        <p>Adicione clicando <a href="?page=orders&action=menu">Aqui</a></p>
                    </li>
                `);

                $('.button-order').prop('disabled', true);
            }
        },
        error: function () {
            Swal.fire({
                title: 'Erro!',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })
        }
    });
}

const changeCart = (direction) => {

    if (direction == 'invert') {

        $('.main-item-modal.-cart').css('right', '360px').css('opacity', '0');

        $('.cart-tables-wrapper').css('right', '0').css('opacity', '1');

        $('.button-order.continue').removeClass('continue').addClass('finish');
        $('.button-order.finish').text('Finalizar Pedido');

    } else if (direction == 'revert') {

        $('.main-item-modal.-cart').css('right', '0').css('opacity', '1');
        $('.cart-tables-wrapper').css('right', '-360px').css('opacity', '0');

        $('.button-order.finish').removeClass('finish').addClass('continue');
        $('.button-order.continue').html('Continuar <i class="fa-solid fa-arrow-right"></i>');
    }

}

$('body').on('click', '.cart-edit-amount button', function() {

    let product = $(this).closest('[data-cart-id]');

    let quantity = $(product).find('input')[0].value;

    if ($(this).data('action') == 'increment') {

        $(product).find('input')[0].value = parseInt(quantity) + 1;

    } else {

        $(product).find('input')[0].value = parseInt(quantity) - 1;
    }

    $(product).find('input').trigger('change');
})

$('body').on('change', '.input-cart-amount', function(event) {
    
    let product = $(this).closest('[data-cart-id]').data();

    if (event.target.value == 0) {

        Swal.fire({
            title: 'Atenção',
            text: 'Deseja remover o Produto do Carrinho?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if (result.isConfirmed) {
               
                $.ajax({
                    url: SERVER_HOST + '/api/?api=cart&action=removeProduct',
                    type: 'POST',
                    data: {
                        cartId: product.cartId
                    },
                    dataType: 'json',
                    success: function(data) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: data.message,
                            icon: 'success'
                        })

                        readCart();
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                            icon: 'error'
                        })
                    }
                }); 

            }
        })
    }

    if (event.target.value <= 0 || event.target.value > 99) {
        event.target.value = 1;
    }

    delay(function() {

        $.ajax({
            url: SERVER_HOST + '/api/?api=cart&action=changeQuantity',
            type: 'POST',
            data: {
                quantity: event.target.value,
                cartId: product.cartId
            },
            dataType: 'json',
            error: function (jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })
            }
        });
    
    }, 400);
})

$('.button-order.cancel').click(function() {
    
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
                            title: 'Sucesso!',
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

$('body').on('click', '.button-order.finish', function(event) {
    let tableChecked = $('.cart-tables-wrapper ul li.table-checked');

    if (!tableChecked.length) {
        Swal.fire({
            title: 'Oops...',
            text: 'Para finalizar o pedido, é necessário que alguma mesa seja selecionada.',
            icon: 'warning'
        })

        return false;
    }

    let tableId = tableChecked[0].dataset.tableId;

    let finishButton = $(this);

    $.ajax({
        url: SERVER_HOST + '/api/?api=cart&action=finishOrder',
        type: 'POST',
        data: {
            tableId
        },
        dataType: 'json',
        success: function(data) {

            if (data.response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.message,
                    icon: 'success'
                })
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                }) 
            }

            readCart();
            
            $('.cart-tables-wrapper ul li').removeClass('table-checked');

            changeCart('revert');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })
        }

    })
})

$('body').on('click', '.button-order.continue', function(event) {
    
    changeCart('invert');
})

$('.modal-subtitle-wrapper i').click(function() {
    changeCart('revert');
})

$('.cart-tables-wrapper ul .element-table').click(function(event) {
    var item = event.target.closest('li');

    if ($(item).hasClass('table-checked')) {
        $(this).removeClass('table-checked');

    } else {
        $('.cart-tables-wrapper ul li').removeClass('table-checked');
            
        $(this).addClass('table-checked');
    }
})