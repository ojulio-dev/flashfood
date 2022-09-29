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
        var statusData = {
            statusId: $(event.target).data('id'),
            statusAction: 'category'
        }

        event.preventDefault();

        $.ajax({
            url: BASE_URL + 'api/?api=changeStatus',
            type: 'POST',
            data: { statusData },
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
                Swal.fire({
                    icon: 'success',
                    title: 'Foi',
                    text: 'Categoria alterada com sucesso!'
                })
            }
        });
    });

    $('.read-table-wrapper .product-table-status input').click(function(event) {
        var statusData = {
            statusId: $(event.target).data('id'),
            statusAction: 'product'
        }

        event.preventDefault();

        $.ajax({
            url: BASE_URL + 'api/?api=changeStatus',
            type: 'POST',
            data: { statusData },
            dataType: 'json',
            success: function (data, status, xhr) {
                var checked = $(event.target).prop('checked')
                $(event.target).prop('checked', !checked);

                Swal.fire({
                    icon: 'success',
                    title: 'Foi',
                    text: 'Produto alterado com sucesso!'
                })
            },
            error: function (jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Eita!',
                    text: data
                })
            }
        });
    });
}); 