$(document).ready(function() {

    $('.orders-search-wrapper #orders-search').keyup(function(event) {

        $('#main-orders-wrapper li.filter-notfound').remove();

        $('.orders-search-wrapper .main-select-form select').val('');

        const search = event.target.value;

        let rows = $('#main-orders-wrapper li');

        rows.each(function(index, li) {
            var orderNumber = $(li).find('strong')[0].innerHTML;

            if (orderNumber.includes(search)) {

                $(li).show();
            } else {

                $(li).hide();
            }

        })

        let visibleRows = $('#main-orders-wrapper li').children(':visible')

        if (!visibleRows.length) {
            $('#main-orders-wrapper').append('<li class="filter-notfound">Não foi encontrado nenhum pedido com o Número digitado...</li>')
        }
    })

    $('.orders-search-wrapper .main-select-form').change(function(event) {

        $('.orders-search-wrapper #orders-search').val('');

        $('#main-orders-wrapper li.filter-notfound').remove();

        const valueStatusId = event.target.value;

        console.log(valueStatusId);

        var rows = $('#main-orders-wrapper li');

        rows.each(function(index, li) {

            var statusId = $(li).find('.status-wrapper small').data('status-id');

            if (statusId == valueStatusId || !valueStatusId) {

                $(li).show();
            } else {

                $(li).hide();
            }
        });

        let visibleRows = $('#main-orders-wrapper li').children(':visible')

        if (!visibleRows.length) {
            $('#main-orders-wrapper').append('<li class="filter-notfound">Não foi encontrado nenhum pedido com o filtro selecionado...</li>')
        }
    })

    $('#menu-search').keyup(function(event) {
        
        delay(function() {
            var search = event.target.value.toLowerCase();
    
            readProducts(search);
        }, 500);

    });

    // Show Orders Modal
    $('body').on('click', '.show-modal-product', function() {

        let productId = $(this).data('product-id');

        $.ajax({
            url: SERVER_HOST + '/api/?api=products&action=listProductById',
            type: 'POST',
            data: {productId},
            dataType: 'json',
            success: function (data) {

                let additionals = data.additionals.map(function(additional) {
                    return (`
                            <li>
                                <input type="checkbox" id="${additional.additional_id}" name="checkboxAdditional" data-additional-id="${additional.additional_id}">
                                <label for="${additional.additional_id}">${additional.name}</label>
                
                                <div class="additionals-edit-quantity" data-additional-id="${additional.additional_id}">
                                    <button type="button" class="button-change-additionals" data-action="decrement"><i class="fa-solid fa-chevron-left"></i></button>
                                    <input type="number" value="1" max="9" min="1" class="input-change-additionals">
                                    <button type="button" class="button-change-additionals" data-action="increment"><i class="fa-solid fa-chevron-right"></i></button>
                                </div>
                            </li>
                        `)
                })

                $('#modal-orders .main-modal-wrapper').html('');

                $('#modal-orders .main-modal-wrapper').append(`

                    <div class="header">
                        <img src="${data.banner}" alt="">
                        <i class="fa-solid fa-xmark icon-exit"></i>
                    </div>

                    <div class="main-item-modal -orders">
                        <div class="modal-orders-items-wrapper">
                            <h2>${data.name}</h2>
                            <small>${data.description}</small>
                            ${data.additionals.length ? `
                                <div>
                                    <div class="additionals-title-wrapper">
                                        <h3>Adicionais</h3>

                                        <span><i class="fa-solid fa-question"></i></span>
                                    </div>

                                    <div class="info-additionals-wrapper">
                                        <h4>Adicionais - Quantidade</h4>
                                        
                                        <div>
                                            <p>Quando a Quantidade do Adicional selecionado for relativa, pense nele como uma porção. Exemplos(Batata-Palha, Cebola, Bacon, etc).</p>

                                            <p>1: Uma pequena Porção;</p>
                                            <p>2: Uma Porção média;</p>
                                            <p>3: Uma grande Porção, etc.</p>
                                        </div>
                                    </div>
                                    
                                    <ul>
                                        ${additionals.join('')}
                                    </ul>
                                </div>`
                            : ''}
                        </div>

                        <button class="button-order success" id="button-add-cart" data-product-id="${data.product_id}">Adicionar ao Carrinho</button>
                    </div>

                `)

                $('#modal-orders').show();

            },
            error: function (jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })
            }
        });

    })

    // Hover additionals info
    $(document).on({
        mouseenter: function () {
            
            $('.main-item-modal.-orders > div > div .info-additionals-wrapper').css('display', 'flex');
        },
        mouseleave: function () {
            $('.main-item-modal.-orders > div > div .info-additionals-wrapper').css('display', 'none')
        }
    }, ".main-item-modal.-orders > div > div .additionals-title-wrapper span");


    $('body').on('click', '.additionals-edit-quantity button', function() {

        let additional = $(this).closest('[data-additional-id]');
    
        let quantity = $(additional).find('input')[0].value;
    
        if ($(this).data('action') == 'increment') {
    
            $(additional).find('input')[0].value = parseInt(quantity) + 1;
    
        } else {
    
            $(additional).find('input')[0].value = parseInt(quantity) - 1;
        }
    
        $(additional).find('input').trigger('change');
    })
    
    $('body').on('change', '.input-change-additionals', function(event) {
        
        let additional = $(this).closest('[data-additional-id]').data();
    
        if (event.target.value <= 0) {

            event.target.value = 1;
        } else if (event.target.value > 9) {

            event.target.value = 9;
        }
    })

    $('body').on('click', '#button-add-cart', (function() {
        
        let productId = $(this).data('product-id');

        let additionals = []

        let checkbox = $('input[name=checkboxAdditional]:checked');

        if (checkbox.length) {
            checkbox.map(function(_, additional) {

                let quantity = $(additional).siblings('div').find('input').val();
                
                additionals = [...additionals, {
                    id: additional.dataset.additionalId,
                    quantity
                }]
            });
        }

        $.ajax({
            url: SERVER_HOST + '/api/?api=cart&action=insertCart',
            type: 'POST',
            data: {
                productId: productId, additionals: additionals
            },
            dataType: 'json',
            success: function (data) {

                data.response && $('#modal-orders').hide();

                Swal.fire({
                    title: data.response ? 'Sucesso!' : 'Oops...',
                    text: data.message,
                    icon: data.response ? 'success' : 'info'
                })
            },
            error: function (jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })
            }
        });

        readCart();

    }));

    // read
    const readProducts = (search) => {
        $.ajax({
            url: SERVER_HOST + `/api/?api=products&action=listProductsOrders&search=${search}`,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data, status, xhr) {

                $('#read-menu-wrapper').html('');
    
                data.length ? data.map(category => {

                    let products = category.products.map(function(product) {

                        let productPrice = new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(product.special_price ?? product.price);

                        return (`
                            <div class="main-orders-item">
                                <a href="#">
                                    <div class="products-image-wrapper">
                                        <img src="${product.banner}">
                                        <button type="button" data-product-id="${product.product_id}" class="show-modal-product"><i class="fa-solid fa-plus"></i></button>
                                    </div>

                                    <strong>${product.name}</strong>
                                    <p>${productPrice}</p>
                                </a>   
                            </div>
                        `)
                    })
                
                    $('#read-menu-wrapper').append(`

                        <li class="main-orders">
                            <div class="menu-category-wrapper">
                                <h3>${category.name}</h3>
                                ${category.products.length >= 4 ? '<a href="#">Ver todos</a>' : '' }
                            </div>

                            <div class="owl-carousel owl-theme">
                                ${products.join('')}
                            </div>
                        </li>
                    `)
                }) : $('#read-menu-wrapper').append('<li class="search-not-found"><i class="fa-solid fa-triangle-exclamation"></i> A sua pesquisa não retornou resultados</li>')

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
})

$('body').on('click', '.orders-image-wrapper', function(event) {

    let orderNumber = this.querySelector('strong').innerHTML;

    orderNumber = orderNumber.replace('#', '');

    $('#modal-order').attr('data-order-number', orderNumber);

    $.ajax({
        url: SERVER_HOST + '/api/?api=orders&action=listByOrderNumber',
        type: 'POST',
        data: {
            orderNumber
        },
        dataType: 'JSON',
        success: function(data) {

            $('.main-modal-wrapper.-order .buttons-wrapper').show();

            if (data[0].status_id == 4) {
                $('.main-modal-wrapper.-order .buttons-wrapper').hide();
            }

            $('#modal-order').show();
            
            $('.main-modal-wrapper.-order .table-orders-wrapper > table > tbody').html('');

            data.map(orderItem => {

                let additionals;

                let productPrice = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }).format(orderItem.product_special_price ?? orderItem.product_price);

                if (orderItem.additionals.length > 0) {
                    additionals = orderItem.additionals.map((additional) => {

                        let additionalPrice = new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(additional.additional_price);

                        return (`
                        
                            <tr class="hidden-line">
                                <td>${additional.additional_name}</td>
                                <td>${additionalPrice}</td>
                                <td>Qtd - ${additional.quantity}</td>
                            </tr>
    
                        `)
                    })
                }

                $('.main-modal-wrapper.-order .table-orders-wrapper > table > tbody').append(`
                    <tr class="visible-line">
                        <td>
                            <img src="${orderItem.product_banner}" alt="Imagem do Produto">
                        </td>
                        <td title="asdsa">${orderItem.category_name}</td>
                        <td>${orderItem.product_name}</td>
                        <td>${productPrice}</td>
                        <td>Qtd - ${orderItem.quantity}</td>
                        <td>${additionals ? '<i class="fa-solid fa-angle-down"></i>' : ''}</td>
                        ${additionals && `
                            <td class="wrapper-additionals">
                                <table>
                                    <tbody>${additionals.join('')}</tbody>
                                </table>
                            </td>
                        `}
                    </tr>
                `);
            })
            
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

const readOrders = () => {
    $.ajax({
        url: SERVER_HOST + '/api/?api=orders&action=listOrders',
        dataType: 'json',
        success: function(data) {
            
            $('#main-orders-wrapper').html('');

            data.map(order => {
                $('#main-orders-wrapper').append(`

                    <style>
                        .main-orders-wrapper li#order-${order.order_number} .orders-image-wrapper .number-status-wrapper .status-wrapper::after {
                            background-color: ${order.status_color};
                        }

                        .main-orders-wrapper li#order-${order.order_number} .orders-image-wrapper .number-status-wrapper .status-wrapper::before {
                            color: ${order.status_color};
                        }
                            
                    </style>

                    <li id="order-${order.order_number}">
                        <div class="orders-image-wrapper">
                            <img src="${DIR_PATH}/assets/images/system/delivery-box.png" alt="Imagem do Pedido">

                            <strong>#${order.order_number}</strong>
                            <div class="number-status-wrapper">
                                <span class="quantity-products">${order.quantity}</span>

                                <span class="status-wrapper">
                                    <small data-status-id="${order.status_id}">${order.status_name[0].toUpperCase() + order.status_name.substr(1)}</small>
                                </span>
                            </div>
                        </div>

                        <div class="orders-info-wrapper">
                            <div>
                                <small>Mesa ${order.table_number}</small>  
                                <span><i class="fa-regular fa-clock"></i> ${order.timeSpent}</span>
                            </div>
                        </div>
                    </li>

                `);
            })

        },
        error: function() {
            Swal.fire({
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })
        }
    });
}

$('body').on('click', '.table-orders-wrapper .visible-line', function(event) {
        
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        
    } else {
        $('.table-orders-wrapper .visible-line').removeClass('active');
        
        $(this).addClass('active');
    }
});

$('body').on('click', '#processing-order-button', function() {
    let orderNumber = $('#modal-order').attr('data-order-number');

    $.ajax({
        url: SERVER_HOST + '/api/?api=orders&action=processingOrder',
        type: "POST",
        data: {
            orderNumber
        },
        dataType: 'json',
        success: function(data) {

            readOrders();

            $('#modal-order').hide();

            Swal.fire({
                title: 'Sucesso!',
                text: 'Pedido finalizado com Sucesso!',
                icon: 'success'
            }) 
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

$('body').on('click', '#cancel-order-button', function() {

    Swal.fire({
        title: 'Cuidado!',
        text: "Tem certeza que deseja cancelar esse Pedido?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, certeza',
        cancelButtonText: 'Voltar'
    }).then((result) => {
        
        if (result.isConfirmed) {
            
            let orderNumber = $('#modal-order').data('order-number');

            $.ajax({
                url: SERVER_HOST + '/api/?api=orders&action=cancelOrder',
                type: "POST",
                data: {
                    orderNumber
                },
                dataType: 'json',
                success: function(data) {

                    readOrders();

                    $('#modal-order').hide();

                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Pedido cancelado com Sucesso!',
                        icon: 'success'
                    }) 
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