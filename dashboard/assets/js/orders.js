$(document).ready(function() {

    let cart = [];

    // read
    const readProducts = (search) => {
        $.ajax({
            url: API_URL + `api/?api=products&action=listProductsOrders&search=${search}`,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data, status, xhr) {

                $('#read-menu-wrapper').html('');
    
                data.length ? data.map(category => {

                    let products = category.products.map(function(product) {
                        return (`
                            <div class="main-orders-item">
                                <a href="#">
                                    <div class="products-image-wrapper">
                                        <img src="${BASE_URL}assets/images/products/${product.banner}">
                                        <button type="button" class="button-add-cart"><i class="fa-solid fa-plus"></i></button>
                                    </div>

                                    <strong>${product.name}</strong>
                                    <p>R$ ${Number(product.special_price).toFixed(2).replace('.', ',')}</p>
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

    $('#menu-search').keyup(delay(function(event) {
        var search = event.target.value.toLowerCase();

        readProducts(search);
    }, 250));
    
})