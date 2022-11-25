$(document).ready(function() {

    $('.main-dashboard-aside li').click(function(event) {
        
        var item = event.target.closest('li');
        
        if ($(item).hasClass('active')) {
            $(item).removeClass('active');
            
        } else {
            $('.main-dashboard-aside li').removeClass('active');
            
            $(item).addClass('active');
        }
    });

    $('.input-mask-money').maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false, allowZero: true, defaultZero: false}).attr('maxlength', 11);

    $('.owl-carousel').owlCarousel({
        loop: false,
        animateOut: 'slideOutDown',
        animateIn: 'flipInX',
        nav: true,
        smartSpeed:450,
        margin: 15,
        nav:true,
        lazyLoad: true,
        autoplay:true,
        autoplayTimeout:5500,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });

    readCart();
});

const changeStatus = (id, table) => {
    statusData = {
        statusId: id,
        table: table
    }

    $.ajax({
        url: API_URL + 'api/?api=changeStatus',
        type: 'POST',
        data: { statusData },
        dataType: 'json',
        success: function (data, status, xhr) {
            var checked = $(event.target).prop('checked')
            $(event.target).prop('checked', !checked);

            Swal.fire({
                icon: 'success',
                title: 'Foi!',
                text: data.message
            })
        },
        error: function (jqXhr, textStatus, errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Eita!',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            })
        }
    });
}

// Show Cart Modal
$('.icon-cart-modal').click(function() {

    $('#modal-cart').show();

});

$('body').on('click', '.icon-exit', function() {

    $('.main-modal').hide();

});

function delay(fn, ms) {
    let timer = 0

    return function(...args) {
      clearTimeout(timer);
      timer = setTimeout(fn.bind(this, ...args), ms || 0);
    }
}

const readCart = () => {
    $.ajax({
        url: API_URL + 'api/?api=cart&action=listCart', 
        dataType: 'json',
        success: function (data) {

            $('.main-item-modal.-cart').html('');

            if (data.length) {
                data.map(function(product) {
                    $('.main-item-modal.-cart').append(`
                        <li>
                            <div class="cart-name-wrapper">
                                <i class="fa-solid fa-cart-shopping icon-cart"></i>

                                <div class="cart-info-wrapper">
                                    <h3>${product.name.length > 15 ? product.name.substr(0, 15) + '...' : product.name}</h3>
                                    <p>R$ ${Number(product.special_price).toFixed(2).replace('.', ',')}</p>
                                </div>
                            </div>
                            <div class="cart-edit-amount">
                                <button type="button" id="button-remove-cart" data-product-id="${product.product_id}">${product.quantity <= 1 ? '<i class="fa-solid fa-down-long"></i>' : '<i class="fa-solid fa-minus"></i>'}</button>
                                <input type="text" value="${product.quantity}" id="input-cart-amount">
                                <button type="button" id="button-insert-cart" data-product-id="${product.product_id}"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </li>
                    `);
                })
            } else {
                $('.main-item-modal.-cart').append(`
                    <li class="cart-empty-wrapper">
                        <p>Você não possui produtos no Carrinho :/</p>
                        <p>Adicione clicando <a href="?page=orders">Aqui</a></p>
                    </li>
                `); 
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