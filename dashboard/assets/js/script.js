$(document).ready(function() {

    let timer;

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
        url: SERVER_HOST + '/api/?api=changeStatus',
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

let timer;

let delay = function(fn, ms) {
    clearTimeout(timer);
    
    timer = setTimeout(fn, ms);
}
