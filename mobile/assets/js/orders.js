$(document).ready(function() {
    setInterval(readOrders, 10000);
})

$('body').on('click', '.main-section-orders .orders-wrapper li', function() {
    let orderId = $(this).data('order-id');

    let orderNumber = $(this).data('order-number');;

    let totalPrice = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format($(this).data('total-price'));

    $('#orders-modal-items .items-wrapper').html(`
        <h2>Pedido ${parseInt(orderNumber)}</h2>

        <ul></ul>

        <div class="price-button-wrapper">
            <strong>${totalPrice}</strong>

            <button>Ok</button>
        </div>
    `);

    $.ajax({
        url: `${SERVER_HOST}/api/?api=orders&action=listByOrderId`,
        type: 'POST',
        data: {orderId},
        dataType: 'json',
        success: function(data) {
            
            $('#orders-modal-items').css('display', 'flex');

            data.map(product => {

                let additionals = product.additionals.map(additional => {
                    return (`
                        <li><i class="fa-solid fa-plus"></i> ${additional.additional_name} (${product.quantity})</li>
                    `);
                }).join('');

                $('#orders-modal-items .items-wrapper > ul').append(`
                
                    <li>
                        <h4>${product.product_name} (${product.quantity})</h4>
    
                        ${additionals.length ? `<ul class="additionals-wrapper">${additionals}</ul>` : ''}
                    </li>
    
                `);
            }).join('');

        },
        error: function() {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            })

        }
    })
})

$('body').on('click', '#modal-orders-close, #orders-modal-items .items-wrapper button', function() {
    $('#orders-modal-items').hide();
})

const readOrders = () => {

    const result = fetch(`${SERVER_HOST}/api/?api=orders&action=listByUserId`)
    .then((response) => response.json())
    .then((result) => {

        if (result.length) {

            $('.main-section-orders .infos-wrapper .orders-wrapper').html('');

            result.map(order => {
    
                $('.main-section-orders .infos-wrapper .orders-wrapper').append(`
                    <li data-order-id="${order.order_id}" data-order-number="${order.order_number}" data-total-price="${order.total_price}">
                        <span>${order.quantity}</span>

                        <strong>#${parseInt(order.order_number)}</strong>

                        <p style="background-color: ${order.status_color};" class="order-status">${order.status_name[0].toUpperCase() + order.status_name.substr(1)}</p>
                    </li>
                `);
            })
        } else {

            $('.main-section-orders .infos-wrapper').html('<p class="notfound">Nenhum pedido foi encontrado</p>');

        }
    })
}