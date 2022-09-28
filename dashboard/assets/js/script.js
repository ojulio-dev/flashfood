const BASE_URL = "http://localhost/FlashFood/dashboard/";

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

    $('.category-read-table .product-table-status input').click(function(event) {
        var categoryId = $(event.target).data('id');

        event.preventDefault();

        $.ajax({
            url: BASE_URL + 'api/?api=category&action=changeStatus',
            type: 'POST',
            data: { categoryId },
            dataType: 'json',
            success: function (data, status, xhr) {
                var checked = $(event.target).prop('checked')
                $(event.target).prop('checked', !checked);

                Swal.fire({
                    icon: 'success',
                    title: 'Foooi',
                    text: 'Categoria alterada com sucesso!'
                })
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(data);
            }
        });
    });

    $('.read-table-wrapper .product-table-status input').click(function(event) {
        var productId = $(event.target).data('id');

        event.preventDefault();

        $.ajax({
            url: BASE_URL + 'api/?api=products&action=changeStatus',
            type: 'POST',
            data: { productId },
            dataType: 'json',
            success: function (data, status, xhr) {
                var checked = $(event.target).prop('checked')
                $(event.target).prop('checked', !checked);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log('na foi');
            }
        });
    });
}); 