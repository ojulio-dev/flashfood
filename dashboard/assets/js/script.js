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

    $('.product-table-status input').click(function(event) {
        var categoryId = $(event.target).data('id');

        event.preventDefault();

        $.ajax({
            url: BASE_URL + 'api/?api=category&action=change_status',
            type: 'POST',
            data: { categoryId },
            dataType: 'json',
            success: function (data, status, xhr) {
                console.log(data);
                var checked = $(event.target).prop('checked')
                $(event.target).prop('checked', !checked);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(data);
            }
        });
    });
}); 